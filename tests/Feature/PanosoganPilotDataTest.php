<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\IrrigationType;
use App\Enums\SalamStatus;
use App\Enums\SubscriptionPlan;
use App\Models\Farmer;
use App\Models\HarvestRecord;
use App\Models\PlantingSeason;
use App\Models\SalamContract;
use App\Models\Subscription;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanosoganPilotDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_panosogan_pilot_data_is_seeded_correctly(): void
    {
        $this->seed();

        $village = Village::where('nama_desa', 'Desa Panosogan')->first();
        $this->assertNotNull($village);
        $this->assertSame('Kec. Cikeusal', $village->kecamatan);
        $this->assertSame('Kab. Serang', $village->kabupaten);
        $this->assertSame('27.05', (string) $village->total_luas_ha);

        $season = PlantingSeason::where('kode_musim', 'MT-1 2027')->first();
        $this->assertNotNull($season);
        $this->assertTrue($season->status_aktif);
        $this->assertSame('2027-07-17', $season->tanggal_syukuran_panen->toDateString());

        // Check total farmers & total area
        $this->assertSame(48, Farmer::count());
        $this->assertEquals(27.05, (float) Farmer::sum('luas_lahan_ha'));

        // Check Pak Darma
        $darma = Farmer::where('nama', 'Pak Darma')->first();
        $this->assertNotNull($darma);
        $this->assertEquals(0.50, (float) $darma->luas_lahan_ha);
        $this->assertSame('Blok Cibeber', $darma->blok_lahan);
        $this->assertSame(IrrigationType::Paid, $darma->tipe_irigasi);
        $this->assertSame(5, $darma->tipe_irigasi->zakatPercent());

        $darmaSalam = $darma->salamContracts()->first();
        $this->assertNotNull($darmaSalam);
        $this->assertEquals(1750000.00, (float) $darmaSalam->modal_di_muka);
        $this->assertEquals(250.00, (float) $darmaSalam->gabah_dijanjikan_kg);
        $this->assertSame(SalamStatus::Fulfilled, $darmaSalam->status);

        $this->assertEquals(3420000.00, (float) $darma->farmExpenses()->sum('nominal_rp'));

        $darmaHarvest = $darma->harvestRecords()->first();
        $this->assertNotNull($darmaHarvest);
        $this->assertEquals(1850.00, (float) $darmaHarvest->berat_gabah_kg);
        $this->assertEquals(92.50, (float) $darmaHarvest->zakat_kg);
        $this->assertEquals(35.00, (float) $darmaHarvest->leuit_kg);
        $this->assertEquals(8880000.00, (float) $darmaHarvest->pendapatan_bersih);

        $darmaAmanah = $darma->amanahReports()->first();
        $this->assertNotNull($darmaAmanah);
        $this->assertSame('pak-darma-mt1-2027', $darmaAmanah->qr_slug);
        $this->assertSame(11, $darmaAmanah->giliran_air_ditepati);
        $this->assertSame(12, $darmaAmanah->total_giliran_air);
        $this->assertSame(3, $darmaAmanah->pohon_ditanam);

        // Check other key contracts
        $siti = Farmer::where('nama', 'Ibu Siti')->first();
        $this->assertEquals(0.35, (float) $siti->luas_lahan_ha);
        $sitiSalam = $siti->salamContracts()->first();
        $this->assertEquals(1225000.00, (float) $sitiSalam->modal_di_muka);
        $this->assertEquals(175.00, (float) $sitiSalam->gabah_dijanjikan_kg);
        $this->assertSame(SalamStatus::Pending, $sitiSalam->status);

        $rohman = Farmer::where('nama', 'Pak Rohman')->first();
        $this->assertEquals(0.60, (float) $rohman->luas_lahan_ha);
        $rohmanSalam = $rohman->salamContracts()->first();
        $this->assertEquals(2100000.00, (float) $rohmanSalam->modal_di_muka);
        $this->assertEquals(300.00, (float) $rohmanSalam->gabah_dijanjikan_kg);
        $this->assertSame(SalamStatus::Pending, $rohmanSalam->status);

        $jaenudin = Farmer::where('nama', 'Pak Jaenudin')->first();
        $this->assertEquals(0.40, (float) $jaenudin->luas_lahan_ha);
        $jaenudinSalam = $jaenudin->salamContracts()->first();
        $this->assertEquals(1400000.00, (float) $jaenudinSalam->modal_di_muka);
        $this->assertEquals(200.00, (float) $jaenudinSalam->gabah_dijanjikan_kg);
        $this->assertSame(SalamStatus::Partial, $jaenudinSalam->status);

        $euis = Farmer::where('nama', 'Ibu Euis')->first();
        $this->assertEquals(0.30, (float) $euis->luas_lahan_ha);
        $euisSalam = $euis->salamContracts()->first();
        $this->assertEquals(1050000.00, (float) $euisSalam->modal_di_muka);
        $this->assertEquals(150.00, (float) $euisSalam->gabah_dijanjikan_kg);
        $this->assertSame(SalamStatus::Fulfilled, $euisSalam->status);

        // Check aggregate figures
        $this->assertEquals(62100000.00, (float) SalamContract::sum('modal_di_muka'));
        $this->assertEquals(7300.00, (float) SalamContract::sum('gabah_dijanjikan_kg'));
        $this->assertEquals(1200.00, (float) HarvestRecord::sum('leuit_kg'));
        $this->assertSame(150, Subscription::count());
    }
}
