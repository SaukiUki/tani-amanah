<?php

namespace Tests\Feature;

use App\Livewire\Storefront\SubscriptionCheckout;
use App\Models\AmanahReport;
use Database\Seeders\PanosoganPilotSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_storefront_page_is_accessible_and_renders_required_elements(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Beras Amanah');
        $response->assertSee('Koperasi Desa Panosogan');
        $response->assertSee('Bayar per bulan');
        $response->assertSee('3 bulan dibayar di muka');
        $response->assertSee('Pilihan Terpilih');
        $response->assertSee('Kenali Petanimu');
        $response->assertSee('pak-darma-mt1-2027');
        $response->assertSee('Yang Anda Dukung');
        $response->assertSee('Petani Dibayar Rp 7.000/kg');
        $response->assertSee('Modal Tanam Tanpa Ijon');
        $response->assertSee('Cadangan Leuit Desa');
    }

    public function test_livewire_subscription_checkout_component_interaction(): void
    {
        Livewire::test(SubscriptionCheckout::class)
            ->assertSet('selectedPlan', 'quarterly')
            ->call('selectPlan', 'monthly')
            ->assertSet('selectedPlan', 'monthly')
            ->call('selectPlan', 'quarterly')
            ->assertSet('selectedPlan', 'quarterly')
            ->call('openCheckout')
            ->assertSet('showModal', true)
            ->set('nama_pelanggan', 'Hasan Basri')
            ->set('no_wa', '081299998888')
            ->set('alamat', 'Jl. Sukajadi No. 45, RT 02/05, Kebayoran Baru, Jakarta Selatan')
            ->call('checkout')
            ->assertHasNoErrors()
            ->assertSet('isSuccess', true)
            ->assertSee('Instruksi Pembayaran')
            ->assertSee('AMANAH-')
            ->assertSee('7701 0812');

        $this->assertDatabaseHas('subscriptions', [
            'nama_pelanggan' => 'Hasan Basri',
            'no_wa' => '081299998888',
            'paket' => 'quarterly',
            'total_bayar' => 525000,
        ]);
    }

    public function test_rapor_page_renders_farmer_profile_metrics_and_indicators(): void
    {
        $this->seed(PanosoganPilotSeeder::class);

        $report = AmanahReport::where('qr_slug', 'pak-darma-mt1-2027')->first();
        $this->assertNotNull($report, 'Seeded report pak-darma-mt1-2027 must exist');

        $response = $this->get('/rapor/pak-darma-mt1-2027');

        $response->assertStatus(200);
        $response->assertSee('RAPOR AMANAH');
        $response->assertSee('MT-1 2027');
        $response->assertSee('Pak Darma');
        $response->assertSee('Blok Cibeber');
        $response->assertSee('Desa Panosogan');
        $response->assertSee('Silih asih, silih asah, silih asuh');
        $response->assertSee('1.850');
        $response->assertSee('8,88 jt');
        $response->assertSee('Jerami Tidak Dibakar');
        $response->assertSee('Pupuk Sesuai Dosis');
        $response->assertSee('Giliran Air 11 dari 12');
        $response->assertSee('Modal Lewat Akad Salam');
        $response->assertSee('Zakat 92,5 kg Tersalurkan');
        $response->assertSee('Pohon Ditanam 3 Pohon');
        $response->assertSee('Syukuran Panen:');
    }
}
