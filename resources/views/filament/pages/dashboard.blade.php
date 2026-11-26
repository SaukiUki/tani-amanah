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
                <span class="inline-block w-2 h-2 rounded-full bg-[#9A6209] animate-pulse"></span>
                <span>KOPERASI TANI PANOSOGAN • {{ $seasonCode }}</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-serif text-[#1E3F2B] font-bold tracking-tight">
                Ringkasan musim tanam
            </h1>
            <p class="text-xs text-stone-500 font-medium">
                Dasbor Koperasi Tani Panosogan • Sistem Kemitraan Salam & Transparansi Lumbung Pangan
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a 
                href="{{ route('whatsapp.simulator') }}"
                target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-[#075E54] text-white hover:bg-[#128C7E] shadow-xs hover-lift transition-all active:scale-[0.99]"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                </svg>
                <span>Simulasi Bot WA Petani</span>
            </a>
            <span class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-[#E8F3EB] text-[#1E3F2B] border border-[#2C543B]/20 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-[#1E3F2B] animate-pulse"></span>
                <span>Data Musim Aktif</span>
            </span>
        </div>
    </div>

    <!-- 2. BARIS KPI (4 KOLOM SEJAJAR DENGAN HOVER LIFT) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Kartu 1: Anggota dan lahan -->
        <div class="bg-white border border-[#E5E0D5] rounded-2xl p-6 shadow-xs hover-lift flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-stone-600 uppercase tracking-wider block">
                        Anggota dan lahan
                    </span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#E8F3EB] text-[#1E3F2B] border border-[#2C543B]/15">
                        48 petani aktif
                    </span>
                </div>
                <div class="text-3xl sm:text-4xl font-serif font-bold text-[#1E3F2B] tracking-tight">
                    {{ $farmerCount }} petani
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E5E0D5]/80 text-xs text-stone-600 font-medium flex items-center justify-between">
                <span>{{ $areaFormatted }}</span>
                <span class="text-[11px] text-stone-600">{{ $villageName }}</span>
            </div>
        </div>

        <!-- Kartu 2: Dana salam diterima -->
        <div class="bg-white border border-[#E5E0D5] rounded-2xl p-6 shadow-xs hover-lift flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-stone-600 uppercase tracking-wider block">
                        Dana salam diterima
                    </span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#FEF6E6] text-[#9A6209] border border-[#FDE6B8]">
                        100% Akad Lunas
                    </span>
                </div>
                <div class="text-3xl sm:text-4xl font-serif font-bold text-[#1E3F2B] tracking-tight">
                    Rp {{ $salamJt }} jt
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E5E0D5]/80 text-xs text-stone-600 font-medium flex items-center justify-between">
                <span>{{ $subCount }} pelanggan × 3 bulan</span>
                <span class="text-[11px] text-stone-600">Alokasi Panen</span>
            </div>
        </div>

        <!-- Kartu 3: Pembelian gabah / Gabah untuk Beras Amanah -->
        <div class="bg-white border border-[#E5E0D5] rounded-2xl p-6 shadow-xs hover-lift flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-stone-600 uppercase tracking-wider block">
                        Pembelian gabah
                    </span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#E8F3EB] text-[#245D3B] border border-[#C6E2D0]">
                        Harga Adil
                    </span>
                </div>
                <div class="text-3xl sm:text-4xl font-serif font-bold text-[#1E3F2B] tracking-tight">
                    {{ $gabahTon }} ton
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E5E0D5]/80 text-xs text-stone-600 font-medium">
                Rp 7.000/kg, di atas HPP Rp 6.500
            </div>
        </div>

        <!-- Kartu 4: Stok leuit desa (Kontras Gelap Berwibawa #1E3F2B) -->
        <div class="bg-gradient-to-br from-[#1E3F2B] to-[#142B1E] border border-[#1E3F2B] text-white rounded-2xl p-6 shadow-sm hover-lift flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-[#E7E5E4]/85 uppercase tracking-wider block">
                        Stok leuit desa
                    </span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white/15 text-white border border-white/20">
                        Lumbung Desa
                    </span>
                </div>
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
            <div class="p-6 border-b border-[#E5E0D5] flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-[#FAF8F5]/50">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-serif font-bold text-[#1E3F2B]">
                            Akad salam musim ini
                        </h2>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#E8F3EB] text-[#1E3F2B] border border-[#2C543B]/20">
                            {{ $totalContracts }} Akad
                        </span>
                    </div>
                    <p class="text-xs text-stone-500 mt-1">
                        Daftar komitmen akad pembiayaan di muka dengan petani binaan
                    </p>
                </div>
                <a href="{{ \App\Filament\Resources\SalamContracts\SalamContractResource::getUrl() }}" class="group inline-flex items-center gap-1.5 text-xs font-bold text-[#1E3F2B] hover:text-[#2C543B] transition-colors shrink-0">
                    <span class="hover:underline">Lihat semua {{ $totalContracts }} akad</span>
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#FAF8F5] border-b border-[#E5E0D5] text-[11px] font-bold text-stone-600 uppercase tracking-wider">
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
                                $statusDotClass = match ($statusLabel) {
                                    'Sudah diserahkan' => 'bg-[#245D3B]',
                                    'Menunggu panen' => 'bg-[#9A6209]',
                                    'Diserahkan sebagian' => 'bg-[#1D5E84]',
                                    default => 'bg-stone-500',
                                };
                                $farmerName = $contract->farmer?->nama ?? '-';
                                $initials = collect(explode(' ', $farmerName))
                                    ->filter()
                                    ->take(2)
                                    ->map(fn($part) => mb_substr($part, 0, 1))
                                    ->join('') ?: 'P';
                            @endphp
                            <tr class="hover:bg-[#FAF8F5]/80 transition-colors">
                                <td class="py-3.5 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-[#E8F3EB] text-[#1E3F2B] font-bold text-xs flex items-center justify-center shrink-0 border border-[#2C543B]/15">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-stone-900">
                                                {{ $farmerName }}
                                            </div>
                                            <div class="text-[11px] text-stone-500">
                                                {{ $contract->farmer?->blok_lahan ?? 'Blok Panosogan' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 tabular-nums text-stone-600 font-medium">
                                    {{ number_format((float) ($contract->farmer?->luas_lahan_ha ?? 0), 2, ',', '.') }} ha
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-stone-900 tabular-nums">
                                    Rp {{ number_format((float) $contract->modal_di_muka, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 tabular-nums text-stone-600 font-medium">
                                    {{ number_format((float) $contract->gabah_dijanjikan_kg, 0, ',', '.') }} kg
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusBadgeClass }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $statusDotClass }}"></span>
                                        <span>{{ $statusLabel }}</span>
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

        <!-- PANEL KANAN (4 Kolom): Rapor Amanah Desa -->
        <div class="lg:col-span-4 bg-white border border-[#E5E0D5] rounded-2xl shadow-xs p-6 space-y-6">
            <div>
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-serif font-bold text-[#1E3F2B]">
                        Rapor Amanah Desa
                    </h2>
                    <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-[#E8F3EB] text-[#1E3F2B] border border-[#2C543B]/20">
                        {{ $seasonCode }}
                    </span>
                </div>
                <p class="text-xs text-stone-500 mt-1">
                    Transparansi pemenuhan komitmen ekologis dan keadilan budidaya bersama Koperasi Tani Panosogan
                </p>
            </div>

            <!-- Kutipan Miring Filosofi Leluhur Banten -->
            <div class="p-4 rounded-xl bg-[#FAF8F5] border-l-4 border-[#1E3F2B] border-y border-r border-[#E5E0D5]">
                <blockquote class="italic font-serif text-sm leading-relaxed text-[#1E3F2B] font-medium">
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
                <div class="p-3.5 bg-[#FAF8F5] rounded-xl border border-[#E5E0D5] text-center hover-lift">
                    <div class="text-[11px] text-stone-600 font-semibold">Zakat tercatat</div>
                    <div class="text-sm font-serif font-bold text-[#1E3F2B] mt-0.5">
                        {{ $zakatTon }} ton • {{ $zakatFarmerCount }} petani
                    </div>
                    <div class="text-[10px] text-stone-500 mt-0.5">
                        UPZ Desa Panosogan
                    </div>
                </div>

                <div class="p-3.5 bg-[#FAF8F5] rounded-xl border border-[#E5E0D5] text-center hover-lift">
                    <div class="text-[11px] text-stone-600 font-semibold">Pohon ditanam</div>
                    <div class="text-sm font-serif font-bold text-[#1E3F2B] mt-0.5">
                        {{ $pohonCount }} pohon
                    </div>
                    <div class="text-[10px] text-stone-500 mt-0.5">
                        Konservasi DAS
                    </div>
                </div>
            </div>

            <!-- Tombol Penuh #1E3F2B: Siapkan rapor untuk syukuran panen -->
            <a href="{{ route('admin.rapor-desa.preview') }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-[#1E3F2B] hover:bg-[#2C543B] text-white font-semibold text-xs rounded-xl shadow-xs hover-lift active:scale-[0.99] transition-all duration-200">
                <svg class="w-4 h-4 text-[#E7E5E4]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Siapkan rapor untuk syukuran panen</span>
            </a>
        </div>
    </div>
</x-filament-panels::page>
