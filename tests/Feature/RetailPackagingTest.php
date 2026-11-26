<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\Storefront\CustomerPortal;
use App\Livewire\Storefront\SubscriptionCheckout;
use App\Models\Subscription;
use App\Services\Finance\SubscriptionService;
use Database\Seeders\PanosoganPilotSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RetailPackagingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PanosoganPilotSeeder::class);
    }

    public function test_packaging_options_derive_price_dynamically_from_database(): void
    {
        $service = app(SubscriptionService::class);
        $options = $service->getPackagingOptions();

        $this->assertArrayHasKey(1, $options);
        $this->assertArrayHasKey(3, $options);
        $this->assertArrayHasKey(5, $options);

        // Standar seeder: total_amount 525.000 untuk 30 kg (10kg * 3 bln) = Rp 17.500 / kg
        $this->assertSame(17_500, $options[1]['price']);
        $this->assertSame(52_500, $options[3]['price']);
        $this->assertSame(87_500, $options[5]['price']);

        // Simulasikan jika tarif database berubah (misal beras khusus Rp 20.000/kg)
        Subscription::query()->create([
            'invoice_number' => 'AMANAH-202701-TEST',
            'customer_name' => 'Harga Baru Test',
            'customer_phone' => '081299990000',
            'city' => 'Serang',
            'delivery_address' => 'Desa Panosogan',
            'plan_type' => 'monthly',
            'rice_kg_per_month' => 10,
            'duration_months' => 1,
            'total_amount' => 200_000.00, // Rp 20.000/kg
            'payment_status' => 'paid',
        ]);

        $updatedOptions = $service->getPackagingOptions();
        $this->assertSame(20_000, $updatedOptions[1]['price']);
        $this->assertSame(60_000, $updatedOptions[3]['price']);
        $this->assertSame(100_000, $updatedOptions[5]['price']);
    }

    public function test_customer_portal_allows_ordering_retail_packaging_when_rice_runs_out(): void
    {
        $existingSub = Subscription::query()->first();
        $this->assertNotNull($existingSub);

        Livewire::test(CustomerPortal::class, ['invoice_number' => $existingSub->invoice_number])
            ->assertSee('Beras Habis Sebelum Jadwal Kirim?')
            ->assertSee('Kemasan 1 Kg')
            ->assertSee('Kemasan 3 Kg')
            ->assertSee('Kemasan 5 Kg')
            ->call('selectRetailKg', 5)
            ->call('incrementRetailQty') // qty jadi 2 -> total 10 kg
            ->assertSet('selectedRetailKg', 5)
            ->assertSet('retailQuantity', 2)
            ->call('orderRetailPack')
            ->assertSet('retailSuccess', true);

        // Verifikasi pesanan retail tersimpan di database
        $retailSub = Subscription::query()
            ->where('customer_phone', $existingSub->customer_phone)
            ->where('plan_type', 'retail_5kg')
            ->first();

        $this->assertNotNull($retailSub);
        $this->assertSame(10, $retailSub->rice_kg_per_month);
        $this->assertEquals(175000.00, (float) $retailSub->total_amount);
        $this->assertSame('pending', $retailSub->payment_status);
    }

    public function test_subscription_checkout_page_allows_buying_retail_packaging(): void
    {
        Livewire::test(SubscriptionCheckout::class)
            ->assertSee('Beli Kemasan 1 Kg, 3 Kg, atau 5 Kg')
            ->call('selectPlan', 'retail_3kg')
            ->assertSet('selectedPlan', 'retail_3kg')
            ->assertSet('selectedPrice', 52_500)
            ->set('customer_name', 'Siti Rahmawati')
            ->set('customer_phone', '081298765432')
            ->set('city', 'Serang')
            ->set('delivery_address', 'Jl. Panosogan Sejahtera No. 45')
            ->call('checkout')
            ->assertSet('isSuccess', true);

        $order = Subscription::query()
            ->where('customer_phone', '081298765432')
            ->where('plan_type', 'retail_3kg')
            ->first();

        $this->assertNotNull($order);
        $this->assertSame(3, $order->rice_kg_per_month);
        $this->assertEquals(52500.00, (float) $order->total_amount);
    }
}
