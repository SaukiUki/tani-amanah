<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rapor Syukuran Panen • {{ $seasonCode }} • Koperasi Tani Panosogan</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background-color: #F5F5F4;
            color: #1C1917;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #FFFFFF !important;
                padding: 0 !important;
            }
            .page-break {
                page-break-before: always;
            }
            .print-card {
                box-shadow: none !important;
                border: 1px solid #E7E5E4 !important;
            }
        }
    </style>
</head>
<body class="py-6 sm:py-10 px-4 sm:px-8">

    <!-- Top Action Bar (No Print) -->
    <div class="no-print max-w-5xl mx-auto mb-6 flex items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-stone-200 shadow-xs">
        <div class="flex items-center gap-3">
            <a href="/admin" class="inline-flex items-center gap-1.5 text-xs font-bold text-stone-600 hover:text-stone-900 bg-stone-100 hover:bg-stone-200 px-3.5 py-2 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dasbor
            </a>
            <span class="text-xs text-stone-400">|</span>
            <span class="text-xs font-semibold text-stone-700">Preview Rapor Desa Panosogan</span>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold bg-[#15803D] hover:bg-[#166534] text-white px-5 py-2.5 rounded-xl shadow-xs hover:shadow transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Rapor / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Main Report Document Wrapper -->
    <div class="max-w-5xl mx-auto bg-white rounded-3xl border border-stone-200 p-6 sm:p-12 shadow-sm space-y-8 print-card">

        <!-- Document Header / Kop Surat Koperasi -->
        <div class="border-b-2 border-stone-800 pb-6">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-[#15803D] text-white flex items-center justify-center shrink-0 shadow-xs">
                        <svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m0-18C8.5 7 5 11 5 16a7 7 0 0014 0c0-5-3.5-9-7-13z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-widest font-extrabold text-[#15803D]">
                            KOPERASI TANI PANOSOGAN
                        </div>
                        <h1 class="text-xl sm:text-2xl font-black text-stone-900 tracking-tight">
                            RAPOR AMANAH & SYUKURAN PANEN DESA
                        </h1>
                        <p class="text-xs sm:text-sm text-stone-600 mt-0.5">
                            {{ $village->nama_desa }}, {{ $village->kecamatan }}, {{ $village->kabupaten }} • Wilayah Banten
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-[#15803D] border border-emerald-300 text-xs font-extrabold uppercase tracking-wider">
                        {{ $seasonCode }}
                    </span>
                    <p class="text-xs text-stone-500 font-semibold mt-1.5">
                        {{ $syukuranDate }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Filosofi Adat Sunda -->
        <div class="bg-amber-50/70 border border-amber-200 rounded-2xl p-5 text-center">
            <div class="text-[11px] font-extrabold uppercase tracking-widest text-amber-800 mb-1">
                Amanah Luhur Budidaya Padi Panosogan
            </div>
            <blockquote class="text-lg sm:text-xl font-black text-amber-950 italic">
                “Lojor teu meunang dipotong, pondok teu meunang disambung.”
            </blockquote>
            <p class="text-xs text-amber-900/80 mt-1 max-w-xl mx-auto">
                Memegang teguh kejujuran apa adanya tanpa manipulasi timbangan, menepati akad salam di hadapan Allah dan sesama, serta menjaga tanah leluhur dengan pupuk berimbang dan tanpa membakar jerami.
            </p>
        </div>

        <!-- 4 KPI Summary Cards -->
        <div>
            <h2 class="text-xs font-bold uppercase tracking-wider text-stone-500 mb-3">
                Ringkasan Capaian Musim Tanam MT-1 2027
            </h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-stone-50 rounded-2xl p-4 border border-stone-200">
                    <div class="text-xs font-semibold text-stone-500">Anggota dan Lahan</div>
                    <div class="text-xl sm:text-2xl font-extrabold text-[#15803D] mt-1 tabular-nums">
                        27,05 ha sawah
                    </div>
                    <div class="text-xs text-stone-600 mt-0.5">
                        48 petani aktif
                    </div>
                </div>

                <div class="bg-stone-50 rounded-2xl p-4 border border-stone-200">
                    <div class="text-xs font-semibold text-stone-500">Dana Salam Diterima</div>
                    <div class="text-xl sm:text-2xl font-extrabold text-[#15803D] mt-1 tabular-nums">
                        Rp 62,1 jt
                    </div>
                    <div class="text-xs text-stone-600 mt-0.5">
                        150 pelanggan × 3 bulan
                    </div>
                </div>

                <div class="bg-stone-50 rounded-2xl p-4 border border-stone-200">
                    <div class="text-xs font-semibold text-stone-500">Pembelian Gabah</div>
                    <div class="text-xl sm:text-2xl font-extrabold text-[#D97706] mt-1 tabular-nums">
                        7,3 ton
                    </div>
                    <div class="text-xs text-stone-600 mt-0.5">
                        Rp 7.000/kg (HPP Rp 6.500)
                    </div>
                </div>

                <div class="bg-stone-50 rounded-2xl p-4 border border-stone-200">
                    <div class="text-xs font-semibold text-stone-500">Stok Leuit Desa</div>
                    <div class="text-xl sm:text-2xl font-extrabold text-[#15803D] mt-1 tabular-nums">
                        1,2 ton
                    </div>
                    <div class="text-xs text-stone-600 mt-0.5">
                        Cadangan pangan & petani darurat
                    </div>
                </div>
            </div>
        </div>

        <!-- Rapor Amanah Ekologis & Sosial Desa -->
        <div class="bg-stone-50 rounded-2xl p-5 border border-stone-200 space-y-4">
            <div class="flex items-center justify-between flex-wrap gap-2">
                <h3 class="text-sm font-extrabold text-stone-900 uppercase tracking-wide">
                    Rapor Amanah Desa & Komitmen Lingkungan
                </h3>
                <span class="text-xs font-semibold text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-full border border-emerald-200">
                    Evaluasi Kolektif: Baik Sekali
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <div>
                    <div class="flex justify-between font-semibold mb-1 text-stone-700">
                        <span>Jerami tidak dibakar</span>
                        <span class="font-bold text-[#15803D]">38 dari 48 (79%)</span>
                    </div>
                    <div class="w-full bg-stone-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-[#15803D] h-2 rounded-full" style="width: 79%;"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between font-semibold mb-1 text-stone-700">
                        <span>Pupuk sesuai dosis</span>
                        <span class="font-bold text-[#15803D]">35 dari 48 (73%)</span>
                    </div>
                    <div class="w-full bg-stone-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-[#15803D] h-2 rounded-full" style="width: 73%;"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between font-semibold mb-1 text-stone-700">
                        <span>Lepas dari ijon</span>
                        <span class="font-bold text-[#15803D]">41 dari 48 (85%)</span>
                    </div>
                    <div class="w-full bg-stone-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-[#15803D] h-2 rounded-full" style="width: 85%;"></div>
                    </div>
                </div>
            </div>

            <div class="pt-3 border-t border-stone-200/80 flex items-center justify-between text-xs text-stone-600 flex-wrap gap-3">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span><strong>Zakat tercatat:</strong> 2,9 ton • 31 petani (Disalurkan ke UPZ Masjid Jami Panosogan)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span><strong>Pohon ditanam:</strong> 126 pohon produktif & perindang</span>
                </div>
            </div>
        </div>

        <!-- Tabel Rekapitulasi Akad Salam & Panen Petani -->
        <div>
            <h3 class="text-sm font-extrabold text-stone-900 uppercase tracking-wide mb-3">
                Rekapitulasi Akad Salam & Panen Petani Anggota
            </h3>
            <div class="overflow-x-auto border border-stone-200 rounded-2xl">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-100 text-stone-700 font-bold border-b border-stone-200 uppercase text-[10px] tracking-wider">
                        <tr>
                            <th class="py-2.5 px-3">No</th>
                            <th class="py-2.5 px-3">Petani</th>
                            <th class="py-2.5 px-3">Blok Lahan</th>
                            <th class="py-2.5 px-3 text-right">Luas (ha)</th>
                            <th class="py-2.5 px-3 text-right">Modal Muka (Rp)</th>
                            <th class="py-2.5 px-3 text-right">Gabah Janji (kg)</th>
                            <th class="py-2.5 px-3 text-right">Gabah Serah (kg)</th>
                            <th class="py-2.5 px-3 text-center">Status Akad</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 font-medium text-stone-800">
                        @foreach($farmers as $index => $f)
                            @php
                                $salam = $f->salamContracts->first();
                                $status = $salam?->status?->value ?? 'pending';
                                $statusLabel = match($status) {
                                    'fulfilled' => 'Sudah diserahkan',
                                    'partial' => 'Diserahkan sebagian',
                                    default => 'Menunggu panen',
                                };
                                $statusBadgeClass = match($status) {
                                    'fulfilled' => 'bg-emerald-100 text-[#15803D] border-emerald-200',
                                    'partial' => 'bg-sky-100 text-sky-800 border-sky-200',
                                    default => 'bg-amber-100 text-[#D97706] border-amber-200',
                                };
                            @endphp
                            <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-stone-50/60' }}">
                                <td class="py-2 px-3 text-stone-400">{{ $index + 1 }}</td>
                                <td class="py-2 px-3 font-bold text-stone-900">{{ $f->nama }}</td>
                                <td class="py-2 px-3 text-stone-600">{{ $f->blok_lahan ?? '-' }}</td>
                                <td class="py-2 px-3 text-right tabular-nums">{{ number_format((float)$f->luas_lahan_ha, 2, ',', '.') }} ha</td>
                                <td class="py-2 px-3 text-right tabular-nums">Rp {{ number_format((float)($salam->modal_di_muka ?? 0), 0, ',', '.') }}</td>
                                <td class="py-2 px-3 text-right tabular-nums">{{ number_format((float)($salam->gabah_dijanjikan_kg ?? 0), 0, ',', '.') }} kg</td>
                                <td class="py-2 px-3 text-right tabular-nums">{{ number_format((float)($salam->gabah_diserahkan_kg ?? 0), 0, ',', '.') }} kg</td>
                                <td class="py-2 px-3 text-center">
                                    <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $statusBadgeClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Lembar Pengesahan & Tanda Tangan -->
        <div class="pt-6 border-t border-stone-200">
            <p class="text-xs text-stone-500 text-center mb-6">
                Rapor ini disahkan secara bersama oleh pengurus koperasi, aparatur desa, dan perwakilan petani pada hari Syukuran Panen MT-1 2027.
            </p>
            <div class="grid grid-cols-3 gap-6 text-center text-xs">
                <div>
                    <p class="text-stone-500 font-semibold mb-16">Ketua Koperasi Tani Panosogan</p>
                    <p class="font-extrabold text-stone-900 underline underline-offset-4">H. Ahmad Fauzi</p>
                    <p class="text-[11px] text-stone-400 mt-0.5">NIA: KTP-2027-001</p>
                </div>
                <div>
                    <p class="text-stone-500 font-semibold mb-16">Perwakilan Petani MT-1</p>
                    <p class="font-extrabold text-stone-900 underline underline-offset-4">Pak Darma</p>
                    <p class="text-[11px] text-stone-400 mt-0.5">Blok Cibeber</p>
                </div>
                <div>
                    <p class="text-stone-500 font-semibold mb-16">Kepala Desa Panosogan</p>
                    <p class="font-extrabold text-stone-900 underline underline-offset-4">Tubagus Sulaeman, S.Sos</p>
                    <p class="text-[11px] text-stone-400 mt-0.5">NIP: 19780512 200501 1 008</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
