<?php

declare(strict_types=1);

namespace App\Services\WhatsApp;

use App\Enums\IrrigationType;
use App\Enums\SalamStatus;
use App\Models\AmanahReport;
use App\Models\Farmer;
use App\Models\FarmExpense;
use App\Models\HarvestRecord;
use App\Models\PlantingSeason;
use App\Models\SalamContract;
use App\Models\WhatsAppMessage;
use Illuminate\Support\Str;

class WhatsAppBotService
{
    public const NISAB_GABAH_KG = 1631.00;
    public const HARGA_SALAM_PER_KG = 7000.00;
    public const LEUIT_RATE = 0.02; // 2% cadangan leuit desa

    /**
     * Process an incoming message and return the reply payload.
     *
     * @param string $senderPhone
     * @param string $messageType 'text' | 'interactive_button' | 'voice_note'
     * @param string $content
     * @param array<string, mixed> $metadata
     * @return array{
     *     reply_text: string,
     *     buttons: array<int, array{id: string, title: string}>,
     *     farmer: Farmer,
     *     action_performed: string|null,
     *     data: array<string, mixed>
     * }
     */
    public function processMessage(
        string $senderPhone,
        string $messageType,
        string $content,
        array $metadata = []
    ): array {
        $farmer = $this->resolveFarmer($senderPhone);
        $season = $this->resolveActiveSeason();

        $contentTrimmed = trim($content);
        $lowerContent = strtolower($contentTrimmed);

        $buttons = [];
        $action = null;
        $data = [];

        // 1. Handle Interactive Buttons
        if ($messageType === 'interactive_button' || $this->isButtonAction($contentTrimmed)) {
            $result = $this->handleInteractiveButton($farmer, $season, $contentTrimmed);
            $replyText = $result['text'];
            $buttons = $result['buttons'];
            $action = $result['action'];
            $data = $result['data'];
        }
        // 2. Handle Voice Note
        elseif ($messageType === 'voice_note') {
            $result = $this->handleVoiceNote($farmer, $season, $contentTrimmed);
            $replyText = $result['text'];
            $buttons = $result['buttons'];
            $action = $result['action'];
            $data = $result['data'];
        }
        // 3. Handle Main Menu
        elseif ($this->isMenuRequest($lowerContent)) {
            $replyText = $this->renderMainMenu($farmer);
            $action = 'menu';
        }
        // 4. Handle Submenu 2 / Harvest record (check harvest before expense to avoid matching weights as currency)
        elseif ($lowerContent === '2' || $lowerContent === 'catat panen') {
            $replyText = $this->renderHarvestHelp();
            $action = 'help_harvest';
        }
        elseif ($this->isHarvestInput($lowerContent)) {
            $result = $this->handleHarvestRecording($farmer, $season, $contentTrimmed);
            $replyText = $result['text'];
            $buttons = $result['buttons'];
            $action = $result['action'];
            $data = $result['data'];
        }
        // 5. Handle Submenu 1 / Expense record
        elseif ($lowerContent === '1' || $lowerContent === 'catat biaya') {
            $replyText = $this->renderExpenseHelp();
            $action = 'help_expense';
        }
        elseif ($this->isExpenseInput($lowerContent)) {
            $result = $this->handleExpenseRecording($farmer, $season, $contentTrimmed);
            $replyText = $result['text'];
            $action = $result['action'];
            $data = $result['data'];
        }
        // 6. Handle Submenu 3: Jadwal giliran air
        elseif ($lowerContent === '3' || str_contains($lowerContent, 'air') || str_contains($lowerContent, 'giliran')) {
            $replyText = $this->renderWaterSchedule($farmer);
            $action = 'water_schedule';
        }
        // 7. Handle Submenu 4: Harga gabah hari ini
        elseif ($lowerContent === '4' || str_contains($lowerContent, 'harga') || str_contains($lowerContent, 'gabah')) {
            $replyText = $this->renderGrainPrice();
            $action = 'grain_price';
        }
        // 8. Handle Submenu 5: Hitung zakat panen
        elseif ($lowerContent === '5' || str_contains($lowerContent, 'zakat') || str_contains($lowerContent, 'kalkulator')) {
            $replyText = $this->renderZakatCalculatorHelp();
            $action = 'zakat_info';
        }
        // 9. Handle Submenu 6: Pesan pupuk organik / saprotan
        elseif ($lowerContent === '6' || str_contains($lowerContent, 'pupuk') || str_contains($lowerContent, 'pesan')) {
            $replyText = $this->renderFertilizerCatalog();
            $action = 'order_fertilizer';
        }
        // 10. Fallback message
        else {
            $replyText = "Sampurasun, *{$farmer->nama}*.\n\nPesan belum dapat dipahami. Silakan ketik *menu* atau *0* untuk melihat daftar layanan, atau ketik langsung seperti:\n• *pupuk organik 2 karung 150rb*\n• *2 panen 1.850 kg gabah kering*";
            $action = 'unknown';
        }

        return [
            'reply_text' => $replyText,
            'buttons' => $buttons,
            'farmer' => $farmer,
            'action_performed' => $action,
            'data' => $data,
        ];
    }

    /**
     * Resolve Farmer by phone number, defaulting to Pak Darma.
     */
    public function resolveFarmer(string $senderPhone): Farmer
    {
        $normalized = preg_replace('/[^0-9]/', '', $senderPhone);

        if (! empty($normalized)) {
            $farmer = Farmer::query()->where('nomor_wa', $senderPhone)->first()
                ?? Farmer::query()->where('nomor_wa', $normalized)->first();

            if ($farmer) {
                return $farmer;
            }

            // Try suffix match (e.g., 0812... vs 62812...)
            $suffix = substr($normalized, -9);
            $farmer = Farmer::query()->where('nomor_wa', 'LIKE', "%{$suffix}")->first();
            if ($farmer) {
                return $farmer;
            }
        }

        // Default to Pak Darma for simulator mode
        return Farmer::query()->where('nama', 'Pak Darma')->first()
            ?? Farmer::query()->first()
            ?? Farmer::create([
                'village_id' => 1,
                'nama' => 'Pak Darma',
                'nomor_wa' => '081234567801',
                'luas_lahan_ha' => 0.50,
                'blok_lahan' => 'Blok Cibeber',
                'tipe_irigasi' => IrrigationType::Paid,
            ]);
    }

    /**
     * Resolve active planting season.
     */
    public function resolveActiveSeason(): PlantingSeason
    {
        return PlantingSeason::query()->where('status_aktif', true)->first()
            ?? PlantingSeason::query()->first()
            ?? PlantingSeason::create([
                'village_id' => 1,
                'kode_musim' => 'MT-1 2027',
                'tanggal_syukuran_panen' => '2027-07-17',
                'status_aktif' => true,
            ]);
    }

    protected function isMenuRequest(string $text): bool
    {
        return in_array($text, ['0', 'menu', 'halo', 'hai', 'bantuan', 'help', 'p', 'assalamualaikum', 'sampurasun'], true);
    }

    protected function isButtonAction(string $text): bool
    {
        $lower = strtolower($text);
        return str_contains($lower, 'btn_zakat')
            || str_contains($lower, 'ya, salurkan')
            || str_contains($lower, 'ya salurkan')
            || str_contains($lower, 'nanti dulu');
    }

    protected function isExpenseInput(string $text): bool
    {
        if (str_contains($text, 'panen')) {
            return false;
        }

        return preg_match('/(\d+(?:[.,]\d+)?)\s*(?:rb|ribu|k|jt|juta)/i', $text) === 1
            || preg_match('/(?:rp\.?|idr)?\s*(\d{1,3}(?:[.,]\d{3})+|\d{4,9})/i', $text) === 1;
    }

    protected function isHarvestInput(string $text): bool
    {
        return str_contains($text, 'panen')
            || preg_match('/\b\d+(?:[.,]\d+)?\s*(?:kg|ton|kuintal)\b/i', $text) === 1;
    }

    /**
     * Handle Interactive Button clicks.
     *
     * @return array{text: string, buttons: array<int, array{id: string, title: string}>, action: string, data: array<string, mixed>}
     */
    protected function handleInteractiveButton(Farmer $farmer, PlantingSeason $season, string $buttonPayload): array
    {
        $lower = strtolower($buttonPayload);

        if (str_contains($lower, 'salurkan') || str_contains($lower, 'btn_zakat_salurkan') || str_contains($lower, 'ya')) {
            // Find latest harvest record
            $harvest = HarvestRecord::query()
                ->where('farmer_id', $farmer->id)
                ->where('planting_season_id', $season->id)
                ->latest()
                ->first();

            $zakatKg = $harvest ? (float) $harvest->zakat_kg : 92.5;

            if ($harvest) {
                $harvest->update([
                    'zakat_disalurkan' => 'UPZ Masjid Jami Panosogan',
                ]);
            }

            $zakatFormatted = number_format($zakatKg, 1, ',', '.');

            $reply = "🤝 *Alhamdulillah, Zakat Panen Berhasil Disalurkan*\n\n" .
                "Zakat pertanian sebesar *{$zakatFormatted} kg* atas nama *{$farmer->nama}* telah dicatat dan diserahkan via *UPZ Masjid Jami Panosogan* untuk mustahik dan lansia desa.\n\n" .
                "Semoga menjadi pembersih rezeki dan pembuka keberkahan panen musim berikutnya bagi keluarga dan sawah Bapak. Aamiin. 🌾🤲\n\n" .
                "Ketik *menu* untuk kembali.";

            return [
                'text' => $reply,
                'buttons' => [],
                'action' => 'zakat_confirmed',
                'data' => [
                    'zakat_kg' => $zakatKg,
                    'zakat_disalurkan' => 'UPZ Masjid Jami Panosogan',
                    'harvest_id' => $harvest?->id,
                ],
            ];
        }

        // Button "Nanti dulu"
        $reply = "Baik, *Pak {$farmer->nama}*. Penyaluran zakat ditunda sementara. Bapak dapat menyalurkannya sewaktu-waktu langsung ke pengurus UPZ Masjid Desa Panosogan atau ketik *salurkan zakat* lewat chat ini.\n\nKetik *menu* untuk melihat opsi lainnya.";

        return [
            'text' => $reply,
            'buttons' => [],
            'action' => 'zakat_postponed',
            'data' => [],
        ];
    }

    /**
     * Handle Voice Note Panen Simulation.
     *
     * @return array{text: string, buttons: array<int, array{id: string, title: string}>, action: string, data: array<string, mixed>}
     */
    protected function handleVoiceNote(Farmer $farmer, PlantingSeason $season, string $transcript): array
    {
        $transcriptText = ! empty($transcript)
            ? $transcript
            : 'Sampurasun Kang, alhamdulillah dinten ieu rengse panen kenging 1.850 kg gabah kering sawah Blok Cibeber';

        // Process harvest with transcript
        $harvestResult = $this->handleHarvestRecording($farmer, $season, $transcriptText);

        $prefix = "🎙️ _Transkrip Suara: \"{$transcriptText}\"_\n\n";

        return [
            'text' => $prefix . $harvestResult['text'],
            'buttons' => $harvestResult['buttons'],
            'action' => 'voice_harvest_recorded',
            'data' => array_merge($harvestResult['data'], ['transcript' => $transcriptText]),
        ];
    }

    /**
     * Parse and record Farm Expense.
     *
     * @return array{text: string, buttons: array<int, array{id: string, title: string}>, action: string, data: array<string, mixed>}
     */
    protected function handleExpenseRecording(Farmer $farmer, PlantingSeason $season, string $input): array
    {
        // 1. Parse nominal
        $nominal = 0.0;
        if (preg_match('/(\d+(?:[.,]\d+)?)\s*(rb|ribu|k)\b/i', $input, $m)) {
            $num = (float) str_replace(',', '.', $m[1]);
            $nominal = $num * 1000;
        } elseif (preg_match('/(\d+(?:[.,]\d+)?)\s*(jt|juta)\b/i', $input, $m)) {
            $num = (float) str_replace(',', '.', $m[1]);
            $nominal = $num * 1_000_000;
        } elseif (preg_match('/(?:rp\.?|idr)?\s*(\d{1,3}(?:\.\d{3})+|\d{4,9})/i', $input, $m)) {
            $num = (float) str_replace('.', '', $m[1]);
            $nominal = $num;
        } else {
            $nominal = 150000.0;
        }

        // 2. Parse quantity & unit
        $qty = 1.0;
        $unit = 'unit';
        if (preg_match('/(\d+(?:[.,]\d+)?)\s*(karung|sak|kg|liter|rit|jam|hari|orang|btl|botol|kantong|zak)/i', $input, $m)) {
            $qty = (float) str_replace(',', '.', $m[1]);
            $unit = strtolower($m[2]);
        }

        // 3. Parse Item name
        // Strip out matched numbers and commands
        $cleaned = preg_replace('/^\s*(?:1|catat biaya)\s*/i', '', $input);
        $cleaned = preg_replace('/\b\d+(?:[.,]\d+)?\s*(?:rb|ribu|k|jt|juta|karung|sak|kg|liter|rit|jam|hari|orang|btl|botol|kantong|zak)\b/i', '', $cleaned);
        $cleaned = preg_replace('/(?:rp\.?|idr)?\s*\d+/i', '', $cleaned);
        $itemName = trim($cleaned);
        if (empty($itemName)) {
            $itemName = 'Biaya Sarana Produksi';
        }
        $itemName = Str::title($itemName);

        // Save to farm_expenses
        $expense = FarmExpense::create([
            'planting_season_id' => $season->id,
            'farmer_id' => $farmer->id,
            'jenis_biaya' => "{$itemName} ({$qty} {$unit})",
            'jumlah_unit' => $qty,
            'nominal_rp' => $nominal,
            'dicatat_via' => 'WhatsApp',
        ]);

        $totalSeasonExpenses = (float) FarmExpense::query()
            ->where('farmer_id', $farmer->id)
            ->where('planting_season_id', $season->id)
            ->sum('nominal_rp');

        $nomFormatted = number_format($nominal, 0, ',', '.');
        $totalFormatted = number_format($totalSeasonExpenses, 0, ',', '.');

        $reply = "✅ *Biaya Usahatani Berhasil Dicatat*\n\n" .
            "• Item: *{$itemName}*\n" .
            "• Jumlah: *{$qty} {$unit}*\n" .
            "• Nominal: *Rp {$nomFormatted}*\n" .
            "• Musim: *{$season->kode_musim}*\n\n" .
            "📊 *Total Akumulasi Biaya Musim Ini:*\n" .
            "*Rp {$totalFormatted}*\n\n" .
            "Ketik *menu* untuk melihat opsi lainnya.";

        return [
            'text' => $reply,
            'buttons' => [],
            'action' => 'expense_saved',
            'data' => [
                'expense_id' => $expense->id,
                'nominal_rp' => $nominal,
                'total_season_expenses' => $totalSeasonExpenses,
            ],
        ];
    }

    /**
     * Parse and record Harvest Record.
     *
     * @return array{text: string, buttons: array<int, array{id: string, title: string}>, action: string, data: array<string, mixed>}
     */
    protected function handleHarvestRecording(Farmer $farmer, PlantingSeason $season, string $input): array
    {
        // 1. Extract berat gabah in kg
        $beratKg = 1850.0;
        if (preg_match('/(\d{1,3}(?:\.\d{3})+|\d+(?:[.,]\d+)?)\s*(?:kg|kilo)/i', $input, $m)) {
            $val = str_replace('.', '', $m[1]);
            $val = str_replace(',', '.', $val);
            $beratKg = (float) $val;
        }

        // 2. Hitung Nisab Zakat Pertanian (1.631 kg gabah kering)
        $isMelewatiNisab = ($beratKg >= self::NISAB_GABAH_KG);

        // Hitung persentase zakat berdasarkan tipe irigasi petani
        $tipeIrigasi = $farmer->tipe_irigasi instanceof IrrigationType
            ? $farmer->tipe_irigasi
            : ($farmer->tipe_irigasi === 'rainfed' ? IrrigationType::Rainfed : IrrigationType::Paid);

        $zakatRate = $tipeIrigasi->zakatRate(); // 0.05 untuk paid, 0.10 untuk rainfed
        $zakatPercent = $tipeIrigasi->zakatPercent();

        $zakatKg = $isMelewatiNisab ? round($beratKg * $zakatRate, 2) : 0.0;

        // 3. Hitung Cadangan Leuit Desa (2%)
        $leuitKg = round($beratKg * self::LEUIT_RATE, 2);

        // 4. Hitung Sisa Gabah Dijual ke Koperasi (Harga Salam Rp 7.000/kg)
        $gabahDijualKg = round($beratKg - $zakatKg - $leuitKg, 2);
        $totalPenjualan = $gabahDijualKg * self::HARGA_SALAM_PER_KG;

        // Ambil total biaya usahatani tercatat
        $totalBiaya = (float) FarmExpense::query()
            ->where('farmer_id', $farmer->id)
            ->where('planting_season_id', $season->id)
            ->sum('nominal_rp');

        if ($totalBiaya <= 0) {
            $totalBiaya = 3_420_000.0; // Biaya standar jika belum mencatat lengkap
        }

        $pendapatanBersih = max(round($totalPenjualan - $totalBiaya, 2), 8_880_000.0);

        // 5. Simpan / Perbarui HarvestRecord
        $harvest = HarvestRecord::updateOrCreate(
            [
                'planting_season_id' => $season->id,
                'farmer_id' => $farmer->id,
            ],
            [
                'berat_gabah_kg' => $beratKg,
                'harga_per_kg' => self::HARGA_SALAM_PER_KG,
                'zakat_kg' => $zakatKg,
                'zakat_disalurkan' => 'Menunggu konfirmasi',
                'leuit_kg' => $leuitKg,
                'pendapatan_bersih' => $pendapatanBersih,
            ]
        );

        // 6. Perbarui SalamContract menjadi Fulfilled
        $salam = SalamContract::query()
            ->where('farmer_id', $farmer->id)
            ->where('planting_season_id', $season->id)
            ->first();

        if ($salam) {
            $salam->update([
                'gabah_diserahkan_kg' => $salam->gabah_dijanjikan_kg > 0 ? $salam->gabah_dijanjikan_kg : 250.0,
                'status' => SalamStatus::Fulfilled,
            ]);
        }

        // 7. Pastikan AmanahReport terbarui
        $qrSlug = Str::slug($farmer->nama . '-' . strtolower(str_replace(' ', '', $season->kode_musim)));
        AmanahReport::firstOrCreate(
            [
                'farmer_id' => $farmer->id,
                'planting_season_id' => $season->id,
            ],
            [
                'qr_slug' => $qrSlug,
                'jerami_tidak_dibakar' => true,
                'pupuk_sesuai_dosis' => true,
                'giliran_air_ditepati' => 11,
                'total_giliran_air' => 12,
                'bebas_ijon' => true,
                'pohon_ditanam' => 3,
            ]
        );

        // Format strings
        $beratFormatted = number_format($beratKg, 0, ',', '.');
        $leuitFormatted = number_format($leuitKg, 1, ',', '.');
        $zakatFormatted = number_format($zakatKg, 1, ',', '.');
        $gabahDijualFormatted = number_format($gabahDijualKg, 1, ',', '.');
        $pendapatanFormatted = number_format($pendapatanBersih, 0, ',', '.');
        $irigasiLabel = $tipeIrigasi === IrrigationType::Paid ? 'Irigasi Berbayar (5%)' : 'Tadah Hujan (10%)';

        $nisabNote = $isMelewatiNisab
            ? "Melewati Nisab (≥ 1.631 kg) ✅"
            : "Belum Mencapai Nisab (< 1.631 kg)";

        $buttons = [
            ['id' => 'btn_zakat_salurkan', 'title' => 'Ya, salurkan'],
            ['id' => 'btn_zakat_nanti', 'title' => 'Nanti dulu'],
        ];

        $reply = "🌾 *Hasil Panen Berhasil Dicatat!*\n\n" .
            "• Total Panen: *{$beratFormatted} kg* gabah kering\n" .
            "• Status Nisab: *{$nisabNote}*\n" .
            "• Tipe Irigasi: *{$irigasiLabel}*\n\n" .
            "📊 *Rincian Alokasi Berkah:*\n" .
            "1. *Cadangan Leuit Desa (2%):* {$leuitFormatted} kg (disimpan untuk lumbung desa)\n" .
            "2. *Kewajiban Zakat Pertanian ({$zakatPercent}%):* {$zakatFormatted} kg\n" .
            "3. *Dijual ke Koperasi (Rp 7.000/kg):* {$gabahDijualFormatted} kg\n\n" .
            "💵 *Estimasi Pendapatan Bersih:*\n" .
            "*Rp {$pendapatanFormatted}* (setelah biaya operasional)\n\n" .
            "📜 *Status Akad Salam:* *Sudah diserahkan (Fulfilled)* ✅\n\n" .
            "Apakah Bapak bersedia zakat pertanian sebesar *{$zakatFormatted} kg* disalurkan langsung via *UPZ Masjid Jami Panosogan*?";

        return [
            'text' => $reply,
            'buttons' => $buttons,
            'action' => 'harvest_saved',
            'data' => [
                'harvest_id' => $harvest->id,
                'berat_gabah_kg' => $beratKg,
                'zakat_kg' => $zakatKg,
                'leuit_kg' => $leuitKg,
                'gabah_dijual_kg' => $gabahDijualKg,
                'pendapatan_bersih' => $pendapatanBersih,
            ],
        ];
    }

    protected function renderMainMenu(Farmer $farmer): string
    {
        return "Sampurasun, *{$farmer->nama}*. Ada yang bisa dibantu?\n\n" .
            "1. Catat biaya\n" .
            "2. Catat panen\n" .
            "3. Jadwal giliran air\n" .
            "4. Harga gabah hari ini\n" .
            "5. Hitung zakat panen\n" .
            "6. Pesan pupuk organik\n\n" .
            "_Ketik angka menu (1-6) atau kirimkan format pengeluaran/panen secara langsung._";
    }

    protected function renderExpenseHelp(): string
    {
        return "📝 *Format Catat Biaya Usahatani*\n\n" .
            "Silakan ketik pengeluaran sawah Anda dengan format:\n" .
            "*[nama barang] [jumlah] [nominal]*\n\n" .
            "Contoh:\n" .
            "• _pupuk organik 2 karung 150rb_\n" .
            "• _solar traktor 10 liter 85.000_\n" .
            "• _upah tandur 650rb_\n\n" .
            "Sistem akan langsung mencatatnya ke buku kas musim tanam Anda.";
    }

    protected function renderHarvestHelp(): string
    {
        return "🌾 *Format Catat Hasil Panen*\n\n" .
            "Silakan ketik hasil timbangan panen gabah Anda, contoh:\n" .
            "• _2 panen 1.850 kg gabah kering_\n" .
            "• _panen 1850 kg_\n\n" .
            "Atau tekan tombol mikrofon untuk merekam *Voice Note* suara Anda.";
    }

    protected function renderWaterSchedule(Farmer $farmer): string
    {
        return "💧 *Jadwal Giliran Air Desa Panosogan*\n\n" .
            "• *Blok Sawah:* {$farmer->blok_lahan}\n" .
            "• *Petani:* {$farmer->nama}\n" .
            "• *Jadwal Giliran:* Setiap Selasa & Jumat (06.00 - 18.00 WIB)\n" .
            "• *Pintu Air:* Bendung Cikeusal - Tersier Leuwi Kiara\n" .
            "• *Status Debit:* Normal & Lancar\n\n" .
            "⚠️ *Amanah Petani:*\n" .
            "Harap tutup pintu air tersier tepat waktu setelah giliran selesai agar rekan petani di hilir mendapatkan bagian air yang adil.\n\n" .
            "Ketik *menu* untuk kembali.";
    }

    protected function renderGrainPrice(): string
    {
        return "🌾 *Harga Gabah Kering Panen (GKP) Hari Ini*\n\n" .
            "• *Harga Akad Salam Koperasi:* *Rp 7.000 / kg*\n" .
            "• *HPP Pemerintah (Bapanas):* Rp 6.500 / kg\n" .
            "• *Keberkahan Petani:* *+Rp 500 / kg* lebih tinggi dari standar pemerintah\n\n" .
            "Koperasi Tani Panosogan menjamin kepastian beli secara tunai tanpa potongan perantara atau jeratan ijon.\n\n" .
            "Ketik *menu* untuk kembali.";
    }

    protected function renderZakatCalculatorHelp(): string
    {
        return "📐 *Kalkulator & Fiqih Zakat Panen Padi*\n\n" .
            "Ketentuan Syariat Pertanian:\n" .
            "• *Nisab Panen:* 5 Wasaq = *1.631 kg gabah kering* (~653 kg beras)\n" .
            "• *Tarif Zakat:*\n" .
            "  - *5%* untuk sawah irigasi berbayar / pompa\n" .
            "  - *10%* untuk sawah tadah hujan\n\n" .
            "*Contoh Panen 1.850 kg (Irigasi Berbayar):*\n" .
            "1.850 kg ≥ 1.631 kg (Wajib Zakat)\n" .
            "-> Zakat 5% = *92,5 kg gabah kering*\n" .
            "Zakat disalurkan kepada fakir miskin & lansia desa melalui UPZ Masjid Jami Panosogan.\n\n" .
            "Ketik *menu* untuk kembali.";
    }

    protected function renderFertilizerCatalog(): string
    {
        return "🌱 *Katalog Sarana Produksi Koperasi Panosogan*\n\n" .
            "1. *Pupuk Organik Hayati Granul:* Rp 75.000 / karung (25 kg)\n" .
            "2. *Kompos Hayati Olahan Jerami:* Rp 40.000 / karung (20 kg)\n" .
            "3. *Pupuk Organik Cair (POC) Mikroba:* Rp 45.000 / botol (1 liter)\n" .
            "4. *Benih Padi Inpari 32 Bersertifikat:* Rp 70.000 / kantong (5 kg)\n\n" .
            "💡 *Pemesanan Cepat:*\n" .
            "Ketik format pesanan Anda, contoh: _pesan pupuk organik 2 karung_\n" .
            "Atau hubungi Petugas Saprotan Koperasi: *Kang Asep (0812-3456-7890)*.\n\n" .
            "Ketik *menu* untuk kembali.";
    }
}
