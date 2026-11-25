<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\Storefront\SubscriptionCheckout;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Finance\SubscriptionService;
use Database\Seeders\PanosoganPilotSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SubscriptionCheckoutAndDashboardSyncTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PanosoganPilotSeeder::class);

        $this->admin = User::query()->create([
            'name' => 'Pengelola Koperasi Panosogan',
            'email' => 'admin@taniamanah.id',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_subscription_service_creates_quarterly_subscription_with_salam_allocation(): void
    {
        $service = app(SubscriptionService::class);

        $subscription = $service->createSubscription([
            'customer_name' => 'Fulan bin Fulan',
            'customer_phone' => '081234567899',
            'city' => 'Serang',
            'delivery_address' => 'Jl. Bhayangkara No. 12, Serang, Banten',
            'plan_type' => 'quarterly',
            'payment_method' => 'qris',
        ]);

        $this->assertNotNull($subscription->id);
        $this->assertStringStartsWith('AMANAH-', $subscription->invoice_number);
        $this->assertSame('quarterly', $subscription->plan_type);
        $this->assertSame(3, $subscription->duration_months);
        $this->assertSame(10, $subscription->rice_kg_per_month);
        $this->assertEquals(525000.00, (float) $subscription->total_amount);
        $this->assertEquals(414000.00, (float) $subscription->salam_allocation_amount);
        $this->assertSame('pending', $subscription->payment_status);
        $this->assertNull($subscription->paid_at);

        // Confirm payment
        $confirmed = $service->confirmPayment($subscription);
        $this->assertSame('paid', $confirmed->payment_status);
        $this->assertNotNull($confirmed->paid_at);
    }

    public function test_subscription_service_creates_monthly_subscription_without_upfront_salam_allocation(): void
    {
        $service = app(SubscriptionService::class);

        $subscription = $service->createSubscription([
            'customer_name' => 'Ahmad Dahlan',
            'customer_phone' => '087812345678',
            'city' => 'Jakarta',
            'delivery_address' => 'Jl. Sudirman No. 88, Jakarta Pusat',
            'plan_type' => 'monthly',
            'payment_method' => 'va',
        ]);

        $this->assertSame('monthly', $subscription->plan_type);
        $this->assertSame(1, $subscription->duration_months);
        $this->assertEquals(175000.00, (float) $subscription->total_amount);
        $this->assertEquals(0.00, (float) $subscription->salam_allocation_amount);
        $this->assertSame('pending', $subscription->payment_status);
    }

    public function test_livewire_checkout_flow_from_plan_selection_to_simulation(): void
    {
        $component = Livewire::test(SubscriptionCheckout::class)
            // 1. Initial state is quarterly (Rp 525.000)
            ->assertSet('selectedPlan', 'quarterly')
            ->assertSee('Bayar per bulan')
            ->assertSee('3 bulan dibayar di muka')
            ->assertSee('Pilihan Terpilih')
            ->assertSee('Langganan sekarang')

            // 2. Select monthly
            ->call('selectPlan', 'monthly')
            ->assertSet('selectedPlan', 'monthly')
            ->assertSee('Rp 175.000')

            // 3. Switch back to quarterly
            ->call('selectPlan', 'quarterly')
            ->assertSet('selectedPlan', 'quarterly')

            // 4. Open modal
            ->call('openCheckout')
            ->assertSet('showModal', true)

            // 5. Fill form
            ->set('customer_name', 'Rahmat Hidayat')
            ->set('customer_phone', '081388776655')
            ->set('city', 'Tangerang')
            ->set('delivery_address', 'Jl. Boulevard BSD No. 99, Tangerang Selatan')
            ->set('payment_method', 'qris')

            // 6. Submit checkout
            ->call('checkout')
            ->assertHasNoErrors()
            ->assertSet('isSuccess', true)
            ->assertSet('isPaid', false)
            ->assertSee('Pesanan Berhasil Dicatat!')
            ->assertSee('Instruksi Pembayaran')
            ->assertSee('Rincian Alokasi Modal Tanam ke Desa Panosogan')
            ->assertSee('Rp 414.000')
            ->assertSee('Simulasi Pembayaran Berhasil')

            // 7. Click Simulate Payment Success (auto-redirect to /pesanan/{invoice_number})
            ->call('simulatePaymentSuccess');

        $createdSub = Subscription::where('customer_name', 'Rahmat Hidayat')->first();
        $this->assertNotNull($createdSub);
        $this->assertSame('paid', $createdSub->payment_status);

        $component->assertRedirect(route('order.show', $createdSub->invoice_number));

        // 8. Verify customer portal order page renders with all required sections
        $orderPageResponse = $this->get('/pesanan/' . $createdSub->invoice_number);
        $orderPageResponse->assertStatus(200);
        $orderPageResponse->assertSee('Aktif • Modal Akad Salam Tersalurkan');
        $orderPageResponse->assertSee('Jadwal Pengiriman Beras (10 kg / bulan)');
        $orderPageResponse->assertSee('Jejak Dampak & Petani Mitra');
        $orderPageResponse->assertSee('Pak Darma');
        $orderPageResponse->assertSee('Lihat Rapor Amanah Petani');
        $orderPageResponse->assertSee('/rapor/pak-darma-mt1-2027');

        $this->assertDatabaseHas('subscriptions', [
            'customer_name' => 'Rahmat Hidayat',
            'city' => 'Tangerang',
            'plan_type' => 'quarterly',
            'payment_status' => 'paid',
        ]);
    }

    public function test_dashboard_dynamically_increments_paid_subscriptions_and_salam_funds(): void
    {
        // Initial state from seeder: 150 paid subscriptions
        $initialPaidCount = Subscription::where('payment_status', 'paid')->count();
        $this->assertSame(150, $initialPaidCount);

        // Check dashboard page renders initial figures
        $dashboardResponse = $this->actingAs($this->admin)->get('/admin');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Dana salam diterima');
        $dashboardResponse->assertSee('Rp 62,1 jt');
        $dashboardResponse->assertSee('150 pelanggan × 3 bulan');

        // Create and pay a new subscription via service
        $service = app(SubscriptionService::class);
        $newSub = $service->createSubscription([
            'customer_name' => 'Warga Baru',
            'customer_phone' => '081299887766',
            'city' => 'Jakarta',
            'delivery_address' => 'Jl. Menteng Raya No. 1, Jakarta',
            'plan_type' => 'quarterly',
            'payment_method' => 'qris',
        ]);

        $service->confirmPayment($newSub);

        // Re-check dashboard page: count is now 151, salam sum is now Rp 62,5 jt
        $updatedResponse = $this->actingAs($this->admin)->get('/admin');
        $updatedResponse->assertStatus(200);
        $updatedResponse->assertSee('151 pelanggan × 3 bulan');
        $updatedResponse->assertSee('Rp 62,5 jt');
    }

    public function test_filament_subscriptions_resource_page_and_mark_as_paid_action(): void
    {
        // Create a pending subscription
        $service = app(SubscriptionService::class);
        $pendingSub = $service->createSubscription([
            'customer_name' => 'Pak Haji Komar',
            'customer_phone' => '081234567811',
            'city' => 'Serang',
            'delivery_address' => 'Jl. Veteran No. 5, Kota Serang',
            'plan_type' => 'quarterly',
            'payment_method' => 'va',
        ]);

        $this->assertSame('pending', $pendingSub->payment_status);

        // Check index page renders
        $response = $this->actingAs($this->admin)->get('/admin/subscriptions');
        $response->assertStatus(200);
        $response->assertSee('Pak Haji Komar');
        $response->assertSee('Menunggu');

        // Execute confirm payment via service (identical to Filament action handler)
        $service->confirmPayment($pendingSub);
        $this->assertSame('paid', $pendingSub->fresh()->payment_status);

        // Check index page now shows Lunas
        $responseAfter = $this->actingAs($this->admin)->get('/admin/subscriptions');
        $responseAfter->assertStatus(200);
        $responseAfter->assertSee('Lunas');
    }

    public function test_customer_portal_routes_and_search_by_invoice_and_whatsapp(): void
    {
        // 1. /langganan route is accessible
        $langgananResponse = $this->get('/langganan');
        $langgananResponse->assertStatus(200);
        $langgananResponse->assertSee('Beras Amanah');
        $langgananResponse->assertSee('Langganan sekarang');

        // 2. /cek-pesanan route is accessible
        $cekResponse = $this->get('/cek-pesanan');
        $cekResponse->assertStatus(200);
        $cekResponse->assertSee('Portal Pelanggan');
        $cekResponse->assertSee('Cek Status Pesanan & Pengiriman');

        // 3. Search by WhatsApp in CustomerPortal
        $seededSub = Subscription::first();
        $this->assertNotNull($seededSub);

        Livewire::test(\App\Livewire\Storefront\CustomerPortal::class)
            ->set('query', $seededSub->invoice_number)
            ->call('checkOrder')
            ->assertRedirect(route('order.show', $seededSub->invoice_number));

        Livewire::test(\App\Livewire\Storefront\CustomerPortal::class)
            ->set('query', $seededSub->customer_phone)
            ->call('checkOrder')
            ->assertRedirect(route('order.show', $seededSub->invoice_number));
    }
}
