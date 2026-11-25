<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\PanosoganPilotSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentAdminDashboardTest extends TestCase
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

    public function test_filament_admin_panel_dashboard_renders_with_brand_and_widgets(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Tani Amanah');
        $response->assertSee('Dasbor Koperasi Tani Panosogan');
        $response->assertSee('KOPERASI TANI PANOSOGAN • MT-1 2027');
        $response->assertSee('Siapkan rapor untuk syukuran panen');

        // 4 KPI Summary Widgets
        $response->assertSee('Anggota dan lahan');
        $response->assertSee('27,05 ha sawah');
        $response->assertSee('48 petani aktif');

        $response->assertSee('Dana salam diterima');
        $response->assertSee('Rp 62,1 jt');
        $response->assertSee('150 pelanggan × 3 bulan');

        $response->assertSee('Pembelian gabah');
        $response->assertSee('7,3 ton');
        $response->assertSee('Rp 7.000/kg, di atas HPP Rp 6.500');

        $response->assertSee('Stok leuit desa');
        $response->assertSee('1,2 ton');
        $response->assertSee('Cadangan pangan dan petani darurat');

        // Widget Tabel Akad salam musim ini
        $response->assertSee('Akad salam musim ini');
        $response->assertSee('Pak Darma');

        // Widget Rapor amanah desa
        $response->assertSee('Rapor Amanah Desa');
        $response->assertSee('Lojor teu meunang dipotong, pondok teu meunang disambung');
        $response->assertSee('Jerami tidak dibakar');
        $response->assertSee('38 dari 48');
        $response->assertSee('Pupuk sesuai dosis');
        $response->assertSee('35 dari 48');
        $response->assertSee('Lepas dari ijon');
        $response->assertSee('41 dari 48');
        $response->assertSee('2,9 ton • 31 petani');
        $response->assertSee('126 pohon');
    }

    public function test_rapor_desa_preview_page_is_accessible_and_complete(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/rapor-desa/preview');

        $response->assertStatus(200);
        $response->assertSee('RAPOR AMANAH');
        $response->assertSee('SYUKURAN PANEN DESA');
        $response->assertSee('KOPERASI TANI PANOSOGAN');
        $response->assertSee('MT-1 2027');
        $response->assertSee('Lojor teu meunang dipotong, pondok teu meunang disambung');
        $response->assertSee('27,05 ha sawah');
        $response->assertSee('48 petani aktif');
        $response->assertSee('Rp 62,1 jt');
        $response->assertSee('7,3 ton');
        $response->assertSee('1,2 ton');
        $response->assertSee('Cetak Rapor / Simpan PDF');
        $response->assertSee('Pak Darma');
        $response->assertSee('Ibu Siti');
        $response->assertSee('H. Ahmad Fauzi');
        $response->assertSee('Tubagus Sulaeman, S.Sos');
    }

    public function test_all_four_filament_resources_are_accessible(): void
    {
        $farmersResponse = $this->actingAs($this->admin)->get('/admin/farmers');
        $farmersResponse->assertStatus(200);
        $farmersResponse->assertSee('Petani Binaan');
        $farmersResponse->assertSee('Pak Darma');

        $salamResponse = $this->actingAs($this->admin)->get('/admin/salam-contracts');
        $salamResponse->assertStatus(200);
        $salamResponse->assertSee('Akad Salam');

        $harvestResponse = $this->actingAs($this->admin)->get('/admin/harvest-records');
        $harvestResponse->assertStatus(200);
        $harvestResponse->assertSee('Catatan Panen');

        $subsResponse = $this->actingAs($this->admin)->get('/admin/subscriptions');
        $subsResponse->assertStatus(200);
        $subsResponse->assertSee('Langganan Beras');

        $leuitResponse = $this->actingAs($this->admin)->get('/admin/leuit-ledgers');
        $leuitResponse->assertStatus(200);
        $leuitResponse->assertSee('Leuit');

        $zakatResponse = $this->actingAs($this->admin)->get('/admin/zakat-records');
        $zakatResponse->assertStatus(200);
        $zakatResponse->assertSee('Zakat');

        $amanahResponse = $this->actingAs($this->admin)->get('/admin/amanah-reports');
        $amanahResponse->assertStatus(200);
        $amanahResponse->assertSee('Rapor');
    }

    public function test_sidebar_navigation_labels_and_order(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin');
        $response->assertStatus(200);

        // Sidebar navigation items
        $response->assertSee('Ringkasan');
        $response->assertSee('Anggota dan lahan');
        $response->assertSee('Pembelian gabah');
        $response->assertSee('Akad salam');
        $response->assertSee('Leuit desa');
        $response->assertSee('Pesanan pelanggan');
        $response->assertSee('Zakat panen');
        $response->assertSee('Rapor amanah');

        // Editorial header & badges
        $response->assertSee('Ringkasan musim tanam');
        $response->assertSee('Data Musim Aktif');
        $response->assertSee('Lihat semua 41 akad');
    }
}
