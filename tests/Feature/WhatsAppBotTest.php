<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\IrrigationType;
use App\Enums\SalamStatus;
use App\Livewire\WhatsApp\FarmerChatSimulator;
use App\Models\Farmer;
use App\Models\FarmExpense;
use App\Models\HarvestRecord;
use App\Models\PlantingSeason;
use App\Models\SalamContract;
use App\Models\WhatsAppMessage;
use App\Services\WhatsApp\WhatsAppBotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class WhatsAppBotTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_webhook_get_verification_with_valid_token(): void
    {
        $challenge = 'challenge_test_12345';
        $response = $this->get('/api/webhooks/whatsapp?' . http_build_query([
            'hub_mode' => 'subscribe',
            'hub_verify_token' => config('services.whatsapp.verify_token', 'tani-amanah-secret-token'),
            'hub_challenge' => $challenge,
        ]));

        $response->assertStatus(200);
        $this->assertSame($challenge, $response->getContent());
    }

    public function test_webhook_get_verification_fails_with_invalid_token(): void
    {
        $response = $this->get('/api/webhooks/whatsapp?' . http_build_query([
            'hub_mode' => 'subscribe',
            'hub_verify_token' => 'wrong-token',
            'hub_challenge' => '12345',
        ]));

        $response->assertStatus(403);
    }

    public function test_bot_main_menu_response(): void
    {
        $botService = app(WhatsAppBotService::class);
        $result = $botService->processMessage('081234567801', 'text', 'menu');

        $this->assertSame('menu', $result['action_performed']);
        $this->assertStringContainsString('Sampurasun, *Pak Darma*', $result['reply_text']);
        $this->assertStringContainsString('1. Catat biaya', $result['reply_text']);
        $this->assertStringContainsString('2. Catat panen', $result['reply_text']);
        $this->assertStringContainsString('3. Jadwal giliran air', $result['reply_text']);
        $this->assertStringContainsString('4. Harga gabah hari ini', $result['reply_text']);
        $this->assertStringContainsString('5. Hitung zakat panen', $result['reply_text']);
        $this->assertStringContainsString('6. Pesan pupuk organik', $result['reply_text']);
    }

    public function test_bot_records_expense_correctly(): void
    {
        $darma = Farmer::query()->where('nama', 'Pak Darma')->firstOrFail();
        $initialExpenses = FarmExpense::query()->where('farmer_id', $darma->id)->count();

        $botService = app(WhatsAppBotService::class);
        $result = $botService->processMessage($darma->nomor_wa, 'text', 'pupuk organik 2 karung 150rb');

        $this->assertSame('expense_saved', $result['action_performed']);
        $this->assertStringContainsString('Biaya Usahatani Berhasil Dicatat', $result['reply_text']);
        $this->assertStringContainsString('Rp 150.000', $result['reply_text']);

        // Assert database record
        $this->assertSame($initialExpenses + 1, FarmExpense::query()->where('farmer_id', $darma->id)->count());
        $expense = FarmExpense::query()->find($result['data']['expense_id']);
        $this->assertNotNull($expense);
        $this->assertEquals(150000.00, (float) $expense->nominal_rp);
        $this->assertEquals(2.0, (float) $expense->jumlah_unit);
        $this->assertSame('WhatsApp', $expense->dicatat_via);
    }

    public function test_bot_records_harvest_updates_leuit_nisab_and_salam_contract(): void
    {
        $darma = Farmer::query()->where('nama', 'Pak Darma')->firstOrFail();
        $season = PlantingSeason::query()->where('status_aktif', true)->firstOrFail();

        // Set salam contract to Pending initially to test fulfillment update
        $contract = SalamContract::query()->where('farmer_id', $darma->id)->firstOrFail();
        $contract->update(['status' => SalamStatus::Pending, 'gabah_diserahkan_kg' => 0]);

        $botService = app(WhatsAppBotService::class);
        $result = $botService->processMessage($darma->nomor_wa, 'text', '2 panen 1.850 kg gabah kering');

        $this->assertSame('harvest_saved', $result['action_performed']);
        $this->assertCount(2, $result['buttons']);
        $this->assertSame('btn_zakat_salurkan', $result['buttons'][0]['id']);
        $this->assertSame('Ya, salurkan', $result['buttons'][0]['title']);

        // 1.850 kg >= 1.631 kg (Melewati nisab)
        // Irigasi berbayar (5%) -> zakat 5% = 92.5 kg
        $this->assertEquals(92.50, $result['data']['zakat_kg']);
        // Cadangan Leuit Desa (2%) = 37.0 kg
        $this->assertEquals(37.00, $result['data']['leuit_kg']);

        // Assert HarvestRecord in DB
        $harvest = HarvestRecord::query()
            ->where('farmer_id', $darma->id)
            ->where('planting_season_id', $season->id)
            ->first();
        $this->assertNotNull($harvest);
        $this->assertEquals(1850.00, (float) $harvest->berat_gabah_kg);
        $this->assertEquals(92.50, (float) $harvest->zakat_kg);
        $this->assertEquals(37.00, (float) $harvest->leuit_kg);
        $this->assertEquals(7000.00, (float) $harvest->harga_per_kg);

        // Assert SalamContract fulfilled
        $contract->refresh();
        $this->assertSame(SalamStatus::Fulfilled, $contract->status);
        $this->assertEquals((float) $contract->gabah_dijanjikan_kg, (float) $contract->gabah_diserahkan_kg);
    }

    public function test_interactive_button_confirms_zakat_distribution(): void
    {
        $darma = Farmer::query()->where('nama', 'Pak Darma')->firstOrFail();
        $season = PlantingSeason::query()->where('status_aktif', true)->firstOrFail();

        // Create harvest with unconfirmed zakat
        $harvest = HarvestRecord::query()->updateOrCreate(
            [
                'farmer_id' => $darma->id,
                'planting_season_id' => $season->id,
            ],
            [
                'berat_gabah_kg' => 1850.00,
                'harga_per_kg' => 7000.00,
                'zakat_kg' => 92.50,
                'zakat_disalurkan' => 'Menunggu konfirmasi',
                'leuit_kg' => 37.00,
                'pendapatan_bersih' => 8880000.00,
            ]
        );

        $botService = app(WhatsAppBotService::class);
        $result = $botService->processMessage($darma->nomor_wa, 'interactive_button', 'btn_zakat_salurkan');

        $this->assertSame('zakat_confirmed', $result['action_performed']);
        $this->assertStringContainsString('Alhamdulillah, Zakat Panen Berhasil Disalurkan', $result['reply_text']);
        $this->assertStringContainsString('UPZ Masjid Jami Panosogan', $result['reply_text']);

        // Assert harvest record updated
        $harvest->refresh();
        $this->assertSame('UPZ Masjid Jami Panosogan', $harvest->zakat_disalurkan);
        $this->assertTrue((bool) $harvest->zakat_disalurkan);
    }

    public function test_webhook_post_logs_messages_and_returns_json(): void
    {
        $darma = Farmer::query()->where('nama', 'Pak Darma')->firstOrFail();

        $response = $this->postJson('/api/webhooks/whatsapp', [
            'from' => $darma->nomor_wa,
            'type' => 'text',
            'body' => 'pupuk organik 2 karung 150rb',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('action', 'expense_saved');

        // Check messages logged in whatsapp_messages table
        $inbound = WhatsAppMessage::query()
            ->where('phone_number', $darma->nomor_wa)
            ->where('direction', 'inbound')
            ->latest()
            ->first();
        $this->assertNotNull($inbound);
        $this->assertSame('pupuk organik 2 karung 150rb', $inbound->body);

        $outbound = WhatsAppMessage::query()
            ->where('phone_number', $darma->nomor_wa)
            ->where('direction', 'outbound')
            ->latest()
            ->first();
        $this->assertNotNull($outbound);
        $this->assertStringContainsString('Biaya Usahatani Berhasil Dicatat', $outbound->body);
    }

    public function test_bot_submenus_3_4_5_6_return_informative_responses(): void
    {
        $darma = Farmer::query()->where('nama', 'Pak Darma')->firstOrFail();
        $botService = app(WhatsAppBotService::class);

        // Menu 3: Jadwal giliran air
        $res3 = $botService->processMessage($darma->nomor_wa, 'text', '3');
        $this->assertSame('water_schedule', $res3['action_performed']);
        $this->assertStringContainsString('Jadwal Giliran Air Desa Panosogan', $res3['reply_text']);
        $this->assertStringContainsString('Blok Cibeber', $res3['reply_text']);

        // Menu 4: Harga gabah
        $res4 = $botService->processMessage($darma->nomor_wa, 'text', '4');
        $this->assertSame('grain_price', $res4['action_performed']);
        $this->assertStringContainsString('Rp 7.000 / kg', $res4['reply_text']);
        $this->assertStringContainsString('Rp 6.500 / kg', $res4['reply_text']);

        // Menu 5: Hitung zakat panen
        $res5 = $botService->processMessage($darma->nomor_wa, 'text', '5');
        $this->assertSame('zakat_info', $res5['action_performed']);
        $this->assertStringContainsString('1.631 kg gabah kering', $res5['reply_text']);

        // Menu 6: Pesan pupuk
        $res6 = $botService->processMessage($darma->nomor_wa, 'text', '6');
        $this->assertSame('order_fertilizer', $res6['action_performed']);
        $this->assertStringContainsString('Katalog Sarana Produksi Koperasi Panosogan', $res6['reply_text']);
    }

    public function test_farmer_chat_simulator_component_renders_and_executes_actions(): void
    {
        Livewire::test(FarmerChatSimulator::class)
            ->assertSee('Asisten Tani Amanah')
            ->assertSee('Koperasi Tani Panosogan • WhatsApp')
            ->assertSee('Kirim: Menu')
            ->assertSee('Kirim: pupuk organik 2 karung 150rb')
            ->assertSee('Kirim: 2 panen 1.850 kg gabah kering')
            ->assertSee('Simulasi Voice Note Panen')
            // Test sending preset expense
            ->call('sendPreset', 'pupuk organik 2 karung 150rb')
            ->assertSee('Biaya Usahatani Berhasil Dicatat')
            // Test sending preset harvest
            ->call('sendPreset', '2 panen 1.850 kg gabah kering')
            ->assertSee('Hasil Panen Berhasil Dicatat')
            ->assertSee('Ya, salurkan')
            // Test clicking interactive button
            ->call('clickButton', 'btn_zakat_salurkan', 'Ya, salurkan')
            ->assertSee('Alhamdulillah, Zakat Panen Berhasil Disalurkan');
    }

    public function test_simulator_page_route_is_accessible(): void
    {
        $response = $this->get('/demo-whatsapp');
        $response->assertStatus(200);
        $response->assertSee('Asisten Tani Amanah');
        $response->assertSee('Simulasi Bot WA Petani');
    }

    public function test_storefront_contains_simulator_link(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Simulasi Bot WA Petani');
    }
}
