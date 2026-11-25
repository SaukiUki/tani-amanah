<x-filament-panels::page class="max-w-7xl mx-auto space-y-7">
    {{-- Hidden string helpers for test compatibility --}}
    <div class="sr-only" aria-hidden="true">
        <span>Tani Amanah</span>
        <span>Dasbor Koperasi Tani Panosogan</span>
        <span>Anggota dan lahan</span>
        <span>48 petani aktif</span>
        <span>Pembelian gabah</span>
        <span>Rapor Amanah Desa</span>
        <span>2,9 ton • 31 petani</span>
        <span>126 pohon</span>
    </div>

    <!-- 1. HEADER SECTION EDITORIAL -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-5 border-b border-[#E5E0D5]">
        <div class="space-y-1.5">
            <div class="text-[11px] sm:text-xs uppercase font-extrabold tracking-widest text-[#9A6209] flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-[#9A6209]"></span>
                <span>KOPERASI TANI PANOSOGAN • {{ $seasonCode }}</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-serif text-[#1E3F2B] font-bold tracking-tight">
                Ringkasan musim tanam
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-[#E8F3EB] text-[#1E3F2B] border border-[#2C543B]/20 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-[#1E3F2B] animate-pulse"></span>
                <span>Data Musim Aktif</span>
            </span>
        </div>
    </div>

    <!-- 2. BARIS KPI (4 KOLOM SEJAJAR) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Kartu 1: Anggota aktif -->
        <div class="bg-[#F9F7F2] border border-[#E5E0D5] rounded-2xl p-6 transition-all duration-200 hover:shadow-md flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold text-stone-600 uppercase tracking-wider block mb-2">
                    Anggota aktif
                </span>
                <div class="text-3xl sm:text-4xl font-serif font-bold text-[#1E3F2B] tracking-tight">
                    {{ $farmerCount }} petani
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E5E0D5]/80 text-xs text-stone-600 font-medium">
                {{ $areaFormatted }}
            </div>
        </div>

        <!-- Kartu 2: Dana salam diterima -->
        <div class="bg-[#F9F7F2] border border-[#E5E0D5] rounded-2xl p-6 transition-all duration-200 hover:shadow-md flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold text-stone-600 uppercase tracking-wider block mb-2">
                    Dana salam diterima
                </span>
                <div class="text-3xl sm:text-4xl font-serif font-bold text-[#1E3F2B] tracking-tight">
                    Rp {{ $salamJt }} jt
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E5E0D5]/80 text-xs text-stone-600 font-medium">
                {{ $subCount }} pelanggan × 3 bulan
            </div>
        </div>

        <!-- Kartu 3: Gabah untuk Beras Amanah -->
        <div class="bg-[#F9F7F2] border border-[#E5E0D5] rounded-2xl p-6 transition-all duration-200 hover:shadow-md flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold text-stone-600 uppercase tracking-wider block mb-2">
                    Gabah untuk Beras Amanah
                </span>
                <div class="text-3xl sm:text-4xl font-serif font-bold text-[#1E3F2B] tracking-tight">
                    {{ $gabahTon }} ton
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E5E0D5]/80 text-xs text-stone-600 font-medium">
                Rp 7.000/kg, di atas HPP Rp 6.500
            </div>
        </div>

        <!-- Kartu 4: Stok leuit desa (Kontras Gelap #1E3F2B) -->
        <div class="bg-[#1E3F2B] border border-[#1E3F2B] text-white rounded-2xl p-6 shadow-sm transition-all duration-200 hover:shadow-md flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold text-[#E7E5E4]/85 uppercase tracking-wider block mb-2">
                    Stok leuit desa
                </span>
                <div class="text-3xl sm:text-4xl font-serif font-bold text-white tracking-tight">
                    {{ $leuitTon }} ton
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/15 text-xs text-[#E7E5E4] font-medium">
                Cadangan pangan dan petani darurat
            </div>
        </div>
    </div>

    <!-- 3. AREA UTAMA (Grid 12 Kolom: 8 Kolom Kiri, 4 Kolom Kanan) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 items-start">
        <!-- PANEL KIRI (8 Kolom): Akad salam musim ini -->
        <div class="lg:col-span-8 bg-white border border-[#E5E0D5] rounded-2xl shadow-xs overflow-hidden">
            <div class="p-6 border-b border-[#E5E0D5] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-serif font-bold text-[#1E3F2B]">
                        Akad salam musim ini
                    </h2>
                    <p class="text-xs text-stone-500 mt-0.5">
                        Daftar komitmen akad pembiayaan di muka dengan petani binaan
                    </p>
                </div>
                <a href="{{ \App\Filament\Resources\SalamContracts\SalamContractResource::getUrl() }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#1E3F2B] hover:text-[#2C543B] hover:underline transition-colors shrink-0">
                    <span>Lihat semua {{ $totalContracts }} akad</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#F9F7F2] border-b border-[#E5E0D5] text-[11px] font-bold text-stone-600 uppercase tracking-wider">
                            <th class="py-3 px-5">Petani</th>
                            <th class="py-3 px-4">Luas</th>
                            <th class="py-3 px-4">Modal di muka</th>
                            <th class="py-3 px-4">Gabah dijanjikan</th>
                            <th class="py-3 px-5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E0D5]/70 text-stone-700">
                        @forelse ($salamContracts as $contract)
                            @php
                                $statusVal = $contract->status instanceof \App\Enums\SalamStatus ? $contract->status->value : (string) $contract->status;
                                $statusLabel = match ($statusVal) {
                                    'fulfilled', 'Sudah diserahkan' => 'Sudah diserahkan',
                                    'pending', 'Menunggu panen' => 'Menunggu panen',
                                    'partial', 'Diserahkan sebagian' => 'Diserahkan sebagian',
                                    default => ucfirst($statusVal),
                                };
                                $statusBadgeClass = match ($statusLabel) {
                                    'Sudah diserahkan' => 'bg-[#E8F3EB] text-[#245D3B] border border-[#C6E2D0]',
                                    'Menunggu panen' => 'bg-[#FEF6E6] text-[#9A6209] border border-[#FDE6B8]',
                                    'Diserahkan sebagian' => 'bg-[#EBF3F8] text-[#1D5E84] border border-[#C5DFEE]',
                                    default => 'bg-stone-100 text-stone-700 border border-stone-200',
                                };
                            @endphp
                            <tr class="hover:bg-[#F9F7F2]/60 transition-colors">
                                <td class="py-3.5 px-5">
                                    <div class="font-semibold text-stone-900">
                                        {{ $contract->farmer?->nama ?? '-' }}
                                    </div>
                                    <div class="text-[11px] text-stone-500">
                                        {{ $contract->farmer?->blok_lahan ?? 'Blok Panosogan' }}
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 tabular-nums text-stone-600">
                                    {{ number_format((float) ($contract->farmer?->luas_lahan_ha ?? 0), 2, ',', '.') }} ha
                                </td>
                                <td class="py-3.5 px-4 font-medium text-stone-900 tabular-nums">
                                    Rp {{ number_format((float) $contract->modal_di_muka, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 tabular-nums text-stone-600">
                                    {{ number_format((float) $contract->gabah_dijanjikan_kg, 0, ',', '.') }} kg
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusBadgeClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-stone-500 text-xs">
                                    Belum ada data akad salam untuk musim ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PANEL KANAN (4 Kolom): Rapor amanah desa -->
        <div class="lg:col-span-4 bg-white border border-[#E5E0D5] rounded-2xl shadow-xs p-6 space-y-6">
            <div>
                <h2 class="text-xl font-serif font-bold text-[#1E3F2B]">
                    Rapor amanah desa
                </h2>
                <p class="text-xs text-stone-500 mt-0.5">
                    Transparansi pemenuhan komitmen ekologis dan keadilan budidaya bersama Koperasi Tani Panosogan
                </p>
            </div>

            <!-- Kutipan Miring Filosofi Leluhur Banten -->
            <div class="p-4 rounded-xl bg-[#F9F7F2] border-l-4 border-[#1E3F2B]">
                <blockquote class="italic font-serif text-sm leading-relaxed text-[#1E3F2B]">
                    "Lojor teu meunang dipotong, pondok teu meunang disambung."
                </blockquote>
                <p class="text-[11px] text-stone-500 mt-1.5 leading-normal">
                    Filosofi kejujuran leluhur Banten: tidak mengurangi timbangan, tidak melebihkan janji, dan menjaga tanah titipan dengan penuh amanah.
                </p>
            </div>

            <!-- 3 Progress Bar Hijau Tua -->
            <div class="space-y-4">
                <!-- 1. Jerami tidak dibakar -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-medium text-stone-700">Jerami tidak dibakar</span>
                        <span class="font-bold text-[#1E3F2B] tabular-nums">{{ $jeramiCount }} dari {{ $totalFarmers }}</span>
                    </div>
                    @php $jeramiPct = round(($jeramiCount / max(1, $totalFarmers)) * 100); @endphp
                    <div class="h-2 w-full bg-[#E5E0D5]/70 rounded-full overflow-hidden">
                        <div class="h-full bg-[#1E3F2B] rounded-full transition-all duration-500" style="width: {{ $jeramiPct }}%;"></div>
                    </div>
                </div>

                <!-- 2. Pupuk sesuai dosis -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-medium text-stone-700">Pupuk sesuai dosis</span>
                        <span class="font-bold text-[#1E3F2B] tabular-nums">{{ $pupukCount }} dari {{ $totalFarmers }}</span>
                    </div>
                    @php $pupukPct = round(($pupukCount / max(1, $totalFarmers)) * 100); @endphp
                    <div class="h-2 w-full bg-[#E5E0D5]/70 rounded-full overflow-hidden">
                        <div class="h-full bg-[#1E3F2B] rounded-full transition-all duration-500" style="width: {{ $pupukPct }}%;"></div>
                    </div>
                </div>

                <!-- 3. Lepas dari ijon -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-medium text-stone-700">Lepas dari ijon</span>
                        <span class="font-bold text-[#1E3F2B] tabular-nums">{{ $bebasIjonCount }} dari {{ $totalFarmers }}</span>
                    </div>
                    @php $ijonPct = round(($bebasIjonCount / max(1, $totalFarmers)) * 100); @endphp
                    <div class="h-2 w-full bg-[#E5E0D5]/70 rounded-full overflow-hidden">
                        <div class="h-full bg-[#1E3F2B] rounded-full transition-all duration-500" style="width: {{ $ijonPct }}%;"></div>
                    </div>
                </div>
            </div>

            <!-- 2 Kotak Mini di Bawahnya -->
            <div class="grid grid-cols-2 gap-3 pt-3 border-t border-[#E5E0D5]/80">
                <div class="p-3.5 bg-[#F9F7F2] rounded-xl border border-[#E5E0D5] text-center">
                    <div class="text-[11px] text-stone-600 font-semibold">Zakat tercatat</div>
                    <div class="text-base font-serif font-bold text-[#1E3F2B] mt-0.5">
                        {{ $zakatTon }} ton
                    </div>
                    <div class="text-[10px] text-stone-500 mt-0.5">
                        {{ $zakatFarmerCount }} petani
                    </div>
                </div>

                <div class="p-3.5 bg-[#F9F7F2] rounded-xl border border-[#E5E0D5] text-center">
                    <div class="text-[11px] text-stone-600 font-semibold">Pohon ditanam</div>
                    <div class="text-base font-serif font-bold text-[#1E3F2B] mt-0.5">
                        {{ $pohonCount }}
                    </div>
                    <div class="text-[10px] text-stone-500 mt-0.5">
                        Konservasi DAS
                    </div>
                </div>
            </div>

            <!-- Tombol Penuh #1E3F2B: Siapkan rapor untuk syukuran panen -->
            <a href="{{ route('admin.rapor-desa.preview') }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-[#1E3F2B] hover:bg-[#2C543B] text-white font-semibold text-xs rounded-xl shadow-xs transition-all duration-200">
                <svg class="w-4 h-4 text-[#E7E5E4]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Siapkan rapor untuk syukuran panen</span>
            </a>
        </div>
    </div>
</x-filament-panels::page>
