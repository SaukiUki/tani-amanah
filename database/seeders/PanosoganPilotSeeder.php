<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\IrrigationType;
use App\Enums\SalamStatus;
use App\Enums\SubscriptionPlan;
use App\Models\AmanahReport;
use App\Models\Farmer;
use App\Models\FarmExpense;
use App\Models\HarvestRecord;
use App\Models\PlantingSeason;
use App\Models\SalamContract;
use App\Models\Subscription;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PanosoganPilotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Desa Pilot: Desa Panosogan, Kec. Cikeusal, Kab. Serang (27,05 ha sawah)
        $village = Village::query()->updateOrCreate(
            ['nama_desa' => 'Desa Panosogan', 'kecamatan' => 'Kec. Cikeusal', 'kabupaten' => 'Kab. Serang'],
            ['total_luas_ha' => 27.05]
        );

        // 2. Musim Tanam Aktif: MT-1 2027 (Syukuran Panen: Sabtu 17 Juli 2027)
        $season = PlantingSeason::query()->updateOrCreate(
            ['village_id' => $village->id, 'kode_musim' => 'MT-1 2027'],
            [
                'tanggal_syukuran_panen' => '2027-07-17',
                'status_aktif' => true,
            ]
        );

        // 3. Data Khusus Petani Utama (Mockup & Spesifikasi)
        $keyFarmersData = [
            [
                'nama' => 'Pak Darma',
                'nomor_wa' => '081234567801',
                'luas_lahan_ha' => 0.50,
                'blok_lahan' => 'Blok Cibeber',
                'tipe_irigasi' => IrrigationType::Paid,
                'foto_url' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&q=80&w=400',
                'salam' => [
                    'modal_di_muka' => 1_750_000.00,
                    'gabah_dijanjikan_kg' => 250.00,
                    'gabah_diserahkan_kg' => 250.00,
                    'status' => SalamStatus::Fulfilled,
                ],
                'expenses' => [
                    ['jenis_biaya' => 'Olah Lahan & Traktor', 'jumlah_unit' => 1.0, 'nominal_rp' => 800_000.00],
                    ['jenis_biaya' => 'Benih Padi Unggul Inpari 32', 'jumlah_unit' => 25.0, 'nominal_rp' => 350_000.00],
                    ['jenis_biaya' => 'Biaya Tanam (Tandur Serentak)', 'jumlah_unit' => 1.0, 'nominal_rp' => 650_000.00],
                    ['jenis_biaya' => 'Pupuk Organik & Berimbang', 'jumlah_unit' => 4.0, 'nominal_rp' => 520_000.00],
                    ['jenis_biaya' => 'Penyiangan Gulma & Matun', 'jumlah_unit' => 1.0, 'nominal_rp' => 400_000.00],
                    ['jenis_biaya' => 'Panen & Pengangkutan Gabah', 'jumlah_unit' => 1.0, 'nominal_rp' => 700_000.00],
                ],
                'harvest' => [
                    'berat_gabah_kg' => 1850.00,
                    'harga_per_kg' => 7000.00,
                    'zakat_kg' => 92.50,
                    'zakat_disalurkan' => 'UPZ Masjid Jami Panosogan',
                    'leuit_kg' => 35.00,
                    'pendapatan_bersih' => 8_880_000.00,
                ],
                'amanah' => [
                    'qr_slug' => 'pak-darma-mt1-2027',
                    'jerami_tidak_dibakar' => true,
                    'pupuk_sesuai_dosis' => true,
                    'giliran_air_ditepati' => 11,
                    'total_giliran_air' => 12,
                    'bebas_ijon' => true,
                    'pohon_ditanam' => 3,
                ],
            ],
            [
                'nama' => 'Ibu Siti',
                'nomor_wa' => '081234567802',
                'luas_lahan_ha' => 0.35,
                'blok_lahan' => 'Blok Leuwi Kiara',
                'tipe_irigasi' => IrrigationType::Paid,
                'foto_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=400',
                'salam' => [
                    'modal_di_muka' => 1_225_000.00,
                    'gabah_dijanjikan_kg' => 175.00,
                    'gabah_diserahkan_kg' => 0.00,
                    'status' => SalamStatus::Pending,
                ],
                'expenses' => [
                    ['jenis_biaya' => 'Olah Lahan & Traktor', 'jumlah_unit' => 1.0, 'nominal_rp' => 560_000.00],
                    ['jenis_biaya' => 'Benih Padi Inpari 32', 'jumlah_unit' => 18.0, 'nominal_rp' => 252_000.00],
                    ['jenis_biaya' => 'Tanam (Tandur)', 'jumlah_unit' => 1.0, 'nominal_rp' => 450_000.00],
                ],
                'harvest' => null,
                'amanah' => [
                    'qr_slug' => 'ibu-siti-mt1-2027',
                    'jerami_tidak_dibakar' => true,
                    'pupuk_sesuai_dosis' => true,
                    'giliran_air_ditepati' => 8,
                    'total_giliran_air' => 8,
                    'bebas_ijon' => true,
                    'pohon_ditanam' => 2,
                ],
            ],
            [
                'nama' => 'Pak Rohman',
                'nomor_wa' => '081234567803',
                'luas_lahan_ha' => 0.60,
                'blok_lahan' => 'Blok Pasir Gadung',
                'tipe_irigasi' => IrrigationType::Paid,
                'foto_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=400',
                'salam' => [
                    'modal_di_muka' => 2_100_000.00,
                    'gabah_dijanjikan_kg' => 300.00,
                    'gabah_diserahkan_kg' => 0.00,
                    'status' => SalamStatus::Pending,
                ],
                'expenses' => [
                    ['jenis_biaya' => 'Olah Lahan Traktor', 'jumlah_unit' => 1.0, 'nominal_rp' => 960_000.00],
                    ['jenis_biaya' => 'Benih Inpari 32', 'jumlah_unit' => 30.0, 'nominal_rp' => 420_000.00],
                    ['jenis_biaya' => 'Biaya Tanam', 'jumlah_unit' => 1.0, 'nominal_rp' => 750_000.00],
                ],
                'harvest' => null,
                'amanah' => [
                    'qr_slug' => 'pak-rohman-mt1-2027',
                    'jerami_tidak_dibakar' => true,
                    'pupuk_sesuai_dosis' => true,
                    'giliran_air_ditepati' => 8,
                    'total_giliran_air' => 8,
                    'bebas_ijon' => true,
                    'pohon_ditanam' => 4,
                ],
            ],
            [
                'nama' => 'Pak Jaenudin',
                'nomor_wa' => '081234567804',
                'luas_lahan_ha' => 0.40,
                'blok_lahan' => 'Blok Cibeber',
                'tipe_irigasi' => IrrigationType::Paid,
                'foto_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=400',
                'salam' => [
                    'modal_di_muka' => 1_400_000.00,
                    'gabah_dijanjikan_kg' => 200.00,
                    'gabah_diserahkan_kg' => 100.00,
                    'status' => SalamStatus::Partial,
                ],
                'expenses' => [
                    ['jenis_biaya' => 'Olah Lahan Traktor', 'jumlah_unit' => 1.0, 'nominal_rp' => 640_000.00],
                    ['jenis_biaya' => 'Benih Inpari 32', 'jumlah_unit' => 20.0, 'nominal_rp' => 280_000.00],
                    ['jenis_biaya' => 'Biaya Tanam', 'jumlah_unit' => 1.0, 'nominal_rp' => 520_000.00],
                    ['jenis_biaya' => 'Pupuk Organik', 'jumlah_unit' => 3.0, 'nominal_rp' => 390_000.00],
                ],
                'harvest' => [
                    'berat_gabah_kg' => 800.00,
                    'harga_per_kg' => 7000.00,
                    'zakat_kg' => 40.00,
                    'zakat_disalurkan' => 'UPZ Masjid Jami Panosogan',
                    'leuit_kg' => 25.00,
                    'pendapatan_bersih' => 3_770_000.00,
                ],
                'amanah' => [
                    'qr_slug' => 'pak-jaenudin-mt1-2027',
                    'jerami_tidak_dibakar' => true,
                    'pupuk_sesuai_dosis' => true,
                    'giliran_air_ditepati' => 10,
                    'total_giliran_air' => 10,
                    'bebas_ijon' => true,
                    'pohon_ditanam' => 3,
                ],
            ],
            [
                'nama' => 'Ibu Euis',
                'nomor_wa' => '081234567805',
                'luas_lahan_ha' => 0.30,
                'blok_lahan' => 'Blok Pematang Tengah',
                'tipe_irigasi' => IrrigationType::Rainfed,
                'foto_url' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=400',
                'salam' => [
                    'modal_di_muka' => 1_050_000.00,
                    'gabah_dijanjikan_kg' => 150.00,
                    'gabah_diserahkan_kg' => 150.00,
                    'status' => SalamStatus::Fulfilled,
                ],
                'expenses' => [
                    ['jenis_biaya' => 'Olah Lahan Traktor', 'jumlah_unit' => 1.0, 'nominal_rp' => 480_000.00],
                    ['jenis_biaya' => 'Benih Inpari 32', 'jumlah_unit' => 15.0, 'nominal_rp' => 210_000.00],
                    ['jenis_biaya' => 'Biaya Tanam', 'jumlah_unit' => 1.0, 'nominal_rp' => 400_000.00],
                    ['jenis_biaya' => 'Pupuk Organik & Kompos', 'jumlah_unit' => 2.0, 'nominal_rp' => 260_000.00],
                    ['jenis_biaya' => 'Panen', 'jumlah_unit' => 1.0, 'nominal_rp' => 450_000.00],
                ],
                'harvest' => [
                    'berat_gabah_kg' => 1100.00,
                    'harga_per_kg' => 7000.00,
                    'zakat_kg' => 110.00,
                    'zakat_disalurkan' => 'UPZ Masjid Jami Panosogan',
                    'leuit_kg' => 25.00,
                    'pendapatan_bersih' => 5_150_000.00,
                ],
                'amanah' => [
                    'qr_slug' => 'ibu-euis-mt1-2027',
                    'jerami_tidak_dibakar' => true,
                    'pupuk_sesuai_dosis' => true,
                    'giliran_air_ditepati' => 6,
                    'total_giliran_air' => 6,
                    'bebas_ijon' => true,
                    'pohon_ditanam' => 2,
                ],
            ],
        ];

        // Seed 5 Petani Utama
        foreach ($keyFarmersData as $data) {
            $farmer = Farmer::query()->create([
                'village_id' => $village->id,
                'nama' => $data['nama'],
                'nomor_wa' => $data['nomor_wa'],
                'luas_lahan_ha' => $data['luas_lahan_ha'],
                'blok_lahan' => $data['blok_lahan'],
                'tipe_irigasi' => $data['tipe_irigasi'],
                'foto_url' => $data['foto_url'],
            ]);

            SalamContract::query()->create([
                'planting_season_id' => $season->id,
                'farmer_id' => $farmer->id,
                'modal_di_muka' => $data['salam']['modal_di_muka'],
                'gabah_dijanjikan_kg' => $data['salam']['gabah_dijanjikan_kg'],
                'gabah_diserahkan_kg' => $data['salam']['gabah_diserahkan_kg'],
                'status' => $data['salam']['status'],
            ]);

            foreach ($data['expenses'] as $exp) {
                FarmExpense::query()->create([
                    'planting_season_id' => $season->id,
                    'farmer_id' => $farmer->id,
                    'jenis_biaya' => $exp['jenis_biaya'],
                    'jumlah_unit' => $exp['jumlah_unit'],
                    'nominal_rp' => $exp['nominal_rp'],
                    'dicatat_via' => 'WhatsApp',
                ]);
            }

            if ($data['harvest'] !== null) {
                HarvestRecord::query()->create([
                    'planting_season_id' => $season->id,
                    'farmer_id' => $farmer->id,
                    'berat_gabah_kg' => $data['harvest']['berat_gabah_kg'],
                    'harga_per_kg' => $data['harvest']['harga_per_kg'],
                    'zakat_kg' => $data['harvest']['zakat_kg'],
                    'zakat_disalurkan' => $data['harvest']['zakat_disalurkan'],
                    'leuit_kg' => $data['harvest']['leuit_kg'],
                    'pendapatan_bersih' => $data['harvest']['pendapatan_bersih'],
                ]);
            }

            AmanahReport::query()->create([
                'planting_season_id' => $season->id,
                'farmer_id' => $farmer->id,
                'qr_slug' => $data['amanah']['qr_slug'],
                'jerami_tidak_dibakar' => $data['amanah']['jerami_tidak_dibakar'],
                'pupuk_sesuai_dosis' => $data['amanah']['pupuk_sesuai_dosis'],
                'giliran_air_ditepati' => $data['amanah']['giliran_air_ditepati'],
                'total_giliran_air' => $data['amanah']['total_giliran_air'],
                'bebas_ijon' => $data['amanah']['bebas_ijon'],
                'pohon_ditanam' => $data['amanah']['pohon_ditanam'],
            ]);
        }

        // 4. Generate Sisa 43 Petani (Total 48 Petani)
        // Hitungan Target Presisi:
        // - Total luas lahan: 27,05 ha (5 petani awal = 2.15 ha, sisa = 24.90 ha)
        // - Total dana salam: Rp 62.100.000 (5 petani awal = Rp 7.525.000, sisa = Rp 54.575.000)
        // - Total gabah salam dijanjikan: 7.300 kg (7,3 ton; 5 petani awal = 1.075 kg, sisa = 6.225 kg)
        // - Total stok leuit: 1.200 kg (1,2 ton; Pak Darma + Bu Euis + Pak Jaenudin = 85 kg, sisa = 1.115 kg)
        $remainingFarmersNames = [
            'Pak Sanwani', 'Pak Juhri', 'Pak Madrais', 'Pak Encep', 'Pak Oding',
            'Ibu Ratna', 'Pak Aceng', 'Pak Ujang', 'Ibu Komariah', 'Pak Dedi',
            'Pak Maman', 'Ibu Imas', 'Pak Sahrul', 'Pak Sukarna', 'Pak Rustam',
            'Pak Hidayat', 'Ibu Nunung', 'Pak Aep', 'Pak Badri', 'Ibu Yani',
            'Pak Kosim', 'Pak Wawan', 'Pak Ending', 'Ibu Rohayati', 'Pak Hasan',
            'Pak Sulaeman', 'Pak Cecep', 'Ibu Titin', 'Pak Anang', 'Pak Suryana',
            'Pak Jajang', 'Ibu Kokom', 'Pak Tatang', 'Pak Yayan', 'Pak Endang',
            'Ibu Maya', 'Pak Iwan', 'Pak Samsudin', 'Pak Oman', 'Pak Dadan',
            'Ibu Nurhayati', 'Pak Asep', 'Pak Subandi',
        ];

        $blocks = ['Blok Cibeber', 'Blok Leuwi Kiara', 'Blok Pasir Gadung', 'Blok Pematang Tengah', 'Blok Ranca Ilat', 'Blok Babakan'];

        $targetTotalArea = 27.05;
        $currentArea = 2.15;
        $targetTotalSalam = 62_100_000.00;
        $currentSalam = 7_525_000.00;
        $targetTotalGabah = 7_300.00;
        $currentGabah = 1_075.00;
        $targetTotalLeuit = 1_200.00;
        $currentLeuit = 85.00; // 35 (Darma) + 25 (Jaenudin) + 25 (Euis)

        $countRemaining = count($remainingFarmersNames); // 43
        $accumulatedArea = 0.0;
        $accumulatedSalam = 0.0;
        $accumulatedGabah = 0.0;
        $accumulatedLeuit = 0.0;

        // Tentukan jumlah petani yang panen (misal 30 dari 43 sisanya ikut panen menghasilkan sisa leuit)
        $harvestingFarmersCount = 30;
        $harvestIndex = 0;

        foreach ($remainingFarmersNames as $i => $name) {
            $isLast = ($i === $countRemaining - 1);
            $indexNumber = $i + 6; // 6 to 48

            // Luas Lahan (ha)
            if ($isLast) {
                $area = round($targetTotalArea - $currentArea - $accumulatedArea, 2);
            } else {
                // Variasi natural antara 0.45 ha - 0.70 ha
                $baseArea = 0.45 + (($i % 6) * 0.05); // 0.45, 0.50, 0.55, 0.60, 0.65, 0.70
                $area = round($baseArea, 2);
                $accumulatedArea += $area;
            }

            $irrigation = ($i % 4 === 0) ? IrrigationType::Rainfed : IrrigationType::Paid;
            $block = $blocks[$i % count($blocks)];
            $phone = sprintf('08123456%04d', 7800 + $indexNumber);

            $farmer = Farmer::query()->create([
                'village_id' => $village->id,
                'nama' => $name,
                'nomor_wa' => $phone,
                'luas_lahan_ha' => $area,
                'blok_lahan' => $block,
                'tipe_irigasi' => $irrigation,
                'foto_url' => null,
            ]);

            // Salam Contract
            if ($isLast) {
                $salamModal = round($targetTotalSalam - $currentSalam - $accumulatedSalam, 2);
                $salamGabah = round($targetTotalGabah - $currentGabah - $accumulatedGabah, 2);
            } else {
                // Rata-rata modal sekitar 1.250.000 - 1.300.000
                $salamModal = round(1_100_000 + (($i % 7) * 50_000), 2);
                $salamGabah = round(125.0 + (($i % 7) * 6.0), 2);
                $accumulatedSalam += $salamModal;
                $accumulatedGabah += $salamGabah;
            }

            $statusOptions = [SalamStatus::Fulfilled, SalamStatus::Partial, SalamStatus::Pending, SalamStatus::Pending];
            $status = $statusOptions[$i % count($statusOptions)];
            $gabahDiserahkan = match ($status) {
                SalamStatus::Fulfilled => $salamGabah,
                SalamStatus::Partial => round($salamGabah * 0.5, 2),
                SalamStatus::Pending => 0.0,
            };

            SalamContract::query()->create([
                'planting_season_id' => $season->id,
                'farmer_id' => $farmer->id,
                'modal_di_muka' => $salamModal,
                'gabah_dijanjikan_kg' => $salamGabah,
                'gabah_diserahkan_kg' => $gabahDiserahkan,
                'status' => $status,
            ]);

            // Catatan Biaya Usahatani Standar
            $biayaTraktor = round(800_000 * ($area / 0.5), 2);
            $biayaBenih = round(350_000 * ($area / 0.5), 2);
            $biayaTanam = round(650_000 * ($area / 0.5), 2);

            FarmExpense::query()->create([
                'planting_season_id' => $season->id,
                'farmer_id' => $farmer->id,
                'jenis_biaya' => 'Olah Lahan Traktor',
                'jumlah_unit' => 1.0,
                'nominal_rp' => $biayaTraktor,
                'dicatat_via' => 'WhatsApp',
            ]);
            FarmExpense::query()->create([
                'planting_season_id' => $season->id,
                'farmer_id' => $farmer->id,
                'jenis_biaya' => 'Benih Bersertifikat',
                'jumlah_unit' => round(25.0 * ($area / 0.5), 1),
                'nominal_rp' => $biayaBenih,
                'dicatat_via' => 'WhatsApp',
            ]);
            FarmExpense::query()->create([
                'planting_season_id' => $season->id,
                'farmer_id' => $farmer->id,
                'jenis_biaya' => 'Biaya Tanam (Tandur)',
                'jumlah_unit' => 1.0,
                'nominal_rp' => $biayaTanam,
                'dicatat_via' => 'WhatsApp',
            ]);

            // Harvest Record: alokasikan ke 30 petani agar total pas 1.200 kg (1,2 ton) leuit
            if ($harvestIndex < $harvestingFarmersCount) {
                $isLastHarvest = ($harvestIndex === $harvestingFarmersCount - 1);
                if ($isLastHarvest) {
                    $leuitKg = round($targetTotalLeuit - $currentLeuit - $accumulatedLeuit, 2);
                } else {
                    $leuitKg = round(35.0 + (($harvestIndex % 5) * 1.5), 2); // berkisar ~35 - 41 kg
                    $accumulatedLeuit += $leuitKg;
                }

                $panenKg = round($area * 3700, 2); // produktivitas ~3,7 ton/ha
                $hargaKg = 7000.00;
                $zakatRate = $irrigation->zakatRate();
                $zakatKg = round($panenKg * $zakatRate, 2);
                $totalBiaya = $biayaTraktor + $biayaBenih + $biayaTanam + 1_000_000;
                $pendapatanBersih = round(($panenKg * $hargaKg) - $totalBiaya - ($zakatKg * $hargaKg), 2);

                HarvestRecord::query()->create([
                    'planting_season_id' => $season->id,
                    'farmer_id' => $farmer->id,
                    'berat_gabah_kg' => $panenKg,
                    'harga_per_kg' => $hargaKg,
                    'zakat_kg' => $zakatKg,
                    'zakat_disalurkan' => 'UPZ Masjid Jami Panosogan',
                    'leuit_kg' => $leuitKg,
                    'pendapatan_bersih' => $pendapatanBersih,
                ]);

                $harvestIndex++;
            }

            // Amanah Report
            $slug = Str::slug($name . '-mt1-2027');
            AmanahReport::query()->create([
                'planting_season_id' => $season->id,
                'farmer_id' => $farmer->id,
                'qr_slug' => $slug,
                'jerami_tidak_dibakar' => true,
                'pupuk_sesuai_dosis' => ($i % 10 !== 0),
                'giliran_air_ditepati' => 11 - ($i % 3),
                'total_giliran_air' => 12,
                'bebas_ijon' => true,
                'pohon_ditanam' => 2 + ($i % 4),
            ]);
        }

        // 5. Generate 150 Pelanggan Langganan Beras Amanah
        $subscriberFirstNames = [
            'Budi', 'Ahmad', 'Rina', 'Siti', 'Hendra', 'Dian', 'Eko', 'Maya', 'Bambang', 'Nur',
            'Agus', 'Dewi', 'Rizky', 'Fitri', 'Wahyu', 'Sri', 'Fajar', 'Ratna', 'Aditya', 'Lestari',
            'Dimas', 'Indah', 'Yusuf', 'Putri', 'Taufik', 'Tri', 'Bayu', 'Wulan', 'Arif', 'Anisa',
            'Irfan', 'Mega', 'Reza', 'Gita', 'Gilang', 'Nita', 'Farhan', 'Widya', 'Denny', 'Intan',
            'Rudi', 'Pratiwi', 'Hadi', 'Kartika', 'Doni', 'Safira', 'Ilham', 'Tia', 'Hary', 'Ayu',
        ];

        $subscriberLastNames = [
            'Santoso', 'Pratama', 'Kusuma', 'Wijaya', 'Saputra', 'Setiawan', 'Nugroho', 'Wibowo',
            'Hidayat', 'Gunawan', 'Lestari', 'Utomo', 'Siregar', 'Nasution', 'Kurniawan', 'Ramadhan',
            'Permana', 'Firmansyah', 'Budiman', 'Mahendra', 'Suharto', 'Purnomo', 'Cahyono', 'Iskandar',
        ];

        $cities = [
            'Jakarta Selatan', 'Jakarta Barat', 'Jakarta Timur', 'Tangerang Selatan (BSD)',
            'Kota Tangerang', 'Kota Serang', 'Kota Cilegon', 'Kota Depok', 'Kota Bekasi', 'Kota Bogor',
        ];

        for ($s = 1; $s <= 150; $s++) {
            $fname = $subscriberFirstNames[($s * 3) % count($subscriberFirstNames)];
            $lname = $subscriberLastNames[($s * 7) % count($subscriberLastNames)];
            $fullName = "{$fname} {$lname}";
            $city = $cities[$s % count($cities)];
            $address = "Jl. Melati No. {$s}, Kel. Harapan, {$city}";
            $plan = SubscriptionPlan::Quarterly;
            $startDate = Carbon::create(2027, 1, 1)->addDays(($s * 2) % 120)->toDateString();
            $paidAt = Carbon::parse($startDate);

            Subscription::query()->create([
                'invoice_number' => sprintf('AMANAH-202701-%04d', $s),
                'village_id' => $village->id,
                'planting_season_id' => $season->id,
                'customer_name' => $fullName,
                'customer_phone' => sprintf('0821%08d', 10000000 + $s),
                'city' => $city,
                'delivery_address' => $address,
                'plan_type' => 'quarterly',
                'rice_kg_per_month' => 10,
                'duration_months' => 3,
                'total_amount' => 525_000.00,
                'salam_allocation_amount' => 414_000.00,
                'payment_method' => ($s % 2 === 0) ? 'qris' : 'va',
                'payment_status' => 'paid',
                'paid_at' => $paidAt,

                // Legacy columns for backward compatibility
                'nama_pelanggan' => $fullName,
                'no_wa' => sprintf('0821%08d', 10000000 + $s),
                'alamat' => $address,
                'paket' => $plan,
                'total_bayar' => 525_000.00,
                'status_pembayaran' => 'lunas',
                'tanggal_mulai' => $startDate,
            ]);
        }
    }
}
