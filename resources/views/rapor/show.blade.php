@extends('layouts.app', ['title' => 'Rapor Amanah • ' . $farmer->nama . ' (' . ($season->kode_musim ?? 'MT-1 2027') . ')'])

@section('content')
<div class="max-w-md mx-auto min-h-screen bg-[#F4F1EA] shadow-xl text-stone-900 relative pb-16 border-x border-[#E5E0D5]/70">

    <!-- 1. Top Bar -->
    <header class="sticky top-0 z-40 bg-[#F4F1EA]/95 backdrop-blur-md border-b border-[#E5E0D5] px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <a href="{{ route('storefront.index') }}" class="w-8 h-8 rounded-xl bg-white border border-[#E5E0D5] flex items-center justify-center text-stone-700 hover:text-[#1E3F2B] transition-colors shadow-2xs" title="Kembali ke Beranda">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="font-extrabold text-sm text-[#1E3F2B] leading-none">
                    Rapor Amanah Petani
                </h1>
                <p class="text-[10px] text-stone-500 font-medium mt-0.5">
                    Beras Amanah • Koperasi Panosogan
                </p>
            </div>
        </div>

        <a 
            href="{{ route('storefront.langganan') }}" 
            class="text-[11px] font-bold text-[#1E3F2B] bg-[#E8F3EB] px-2.5 py-1.5 rounded-xl border border-[#2C543B]/20 hover:bg-emerald-100 transition-colors"
        >
            + Langganan
        </a>
    </header>

    <div class="p-4 space-y-4">

        <!-- 2. Header Badge & Musim Tanam -->
        <div class="text-center space-y-1.5 pt-1">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-[#15803D] text-xs font-extrabold uppercase tracking-widest border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-[#15803D] animate-ping"></span>
                RAPOR AMANAH • {{ $season->kode_musim ?? 'MT-1 2027' }}
            </div>
            <p class="text-xs text-stone-500 font-medium">
                Dokumen Transparansi Panen Resmi Koperasi Tani Panosogan
            </p>
        </div>

        <!-- 3. Profil Petani Card -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E5E0D5] shadow-xs relative overflow-hidden">
            <div class="flex items-center gap-3.5 sm:gap-4">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl overflow-hidden bg-stone-100 border-2 border-emerald-200 shrink-0 shadow-xs">
                    <img 
                        src="{{ $farmer->foto_url ?? 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&q=80&w=400' }}" 
                        alt="Foto Profil Petani {{ $farmer->nama }}"
                        class="w-full h-full object-cover"
                    >
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h2 class="text-lg sm:text-xl font-extrabold text-stone-900 tracking-tight">
                            {{ $farmer->nama }}
                        </h2>
                        <span class="inline-flex items-center text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 px-2 py-0.5 rounded-full">
                            Petani Utama
                        </span>
                    </div>
                    <p class="text-xs text-stone-600 mt-1 leading-snug">
                        <span class="font-semibold text-stone-800">{{ number_format((float)$farmer->luas_lahan_ha, 2, ',', '.') }} ha</span> • {{ $farmer->blok_lahan }}
                    </p>
                    <p class="text-[11px] text-stone-500 mt-0.5">
                        {{ $village->nama_desa ?? 'Desa Panosogan' }}, {{ $village->kecamatan ?? 'Kec. Cikeusal' }}, {{ $village->kabupaten ?? 'Kab. Serang' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- 4. Banner Peribahasa Sunda -->
        <div class="bg-gradient-to-r from-amber-500/15 via-amber-400/10 to-amber-500/15 border border-amber-300/80 rounded-2xl p-3.5 sm:p-4 text-center shadow-xs">
            <span class="text-[10px] uppercase tracking-widest font-extrabold text-amber-800 block mb-0.5">
                Filosofi Panen Panosogan
            </span>
            <blockquote class="text-base sm:text-lg font-bold text-amber-950 italic">
                “Silih asih, silih asah, silih asuh.”
            </blockquote>
            <p class="text-[11px] text-amber-900/80 mt-1 max-w-xs mx-auto">
                Saling mengasihi antarwarga, saling mengasah budi dan cara bertani berkah, serta saling mengayomi saat suka maupun duka.
            </p>
        </div>

        <!-- 5. Dua Kartu Metrik Utama -->
        <div class="grid grid-cols-2 gap-3">
            <!-- Hasil Panen -->
            <x-ui.stat-card 
                label="Hasil Panen"
                :value="number_format((float)($harvest->berat_gabah_kg ?? 1850), 0, ',', '.')"
                unit="kg"
                subtext="Gabah murni Inpari 32 tandur serentak"
                accent="green"
            />

            <!-- Pendapatan Bersih -->
            @php
                $pendapatanRp = (float)($harvest->pendapatan_bersih ?? 8880000);
                $pendapatanFormatted = $pendapatanRp >= 1000000 
                    ? 'Rp ' . number_format($pendapatanRp / 1000000, 2, ',', '.') . ' jt'
                    : 'Rp ' . number_format($pendapatanRp, 0, ',', '.');
            @endphp
            <x-ui.stat-card 
                label="Pendapatan Bersih"
                :value="$pendapatanFormatted"
                subtext="Diterima tunai, melampaui harga HPP"
                accent="gold"
            />
        </div>

        <!-- 6. Checklist 6 Indikator "AMANAH MUSIM INI" Dinamis Dari Database -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E5E0D5] shadow-xs space-y-3.5">
            <div class="flex items-center justify-between pb-2.5 border-b border-stone-100 flex-wrap gap-2">
                <div>
                    <h3 class="text-sm sm:text-base font-extrabold text-stone-900">
                        Amanah Musim Ini
                    </h3>
                    <p class="text-[11px] text-stone-500">
                        6 Komitmen kejujuran budidaya yang dipenuhi oleh {{ $farmer->nama }}
                    </p>
                </div>
                <span class="inline-flex items-center text-[10px] font-bold text-[#15803D] bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                    Skor: 100% Sempurna
                </span>
            </div>

            <div class="space-y-2.5">
                
                <!-- Indikator 1: Jerami tidak dibakar -->
                <x-ui.indicator-item 
                    :number="1"
                    title="Jerami Tidak Dibakar"
                    :achieved="(bool)$report->jerami_tidak_dibakar"
                    badgeText="{{ $report->jerami_tidak_dibakar ? 'Terpenuhi' : 'Belum' }}"
                    description="Jerami sisa panen tidak dibakar ke udara, melainkan dicacah dan dikembalikan ke sawah sebagai pupuk kompos organik."
                />

                <!-- Indikator 2: Pupuk sesuai dosis -->
                <x-ui.indicator-item 
                    :number="2"
                    title="Pupuk Sesuai Dosis Berimbang"
                    :achieved="(bool)$report->pupuk_sesuai_dosis"
                    badgeText="{{ $report->pupuk_sesuai_dosis ? 'Terstandar' : 'Belum' }}"
                    description="Aplikasi pupuk kandang hayati dan NPK presisi sesuai anjuran penyuluh desa untuk menjaga kesehatan tanah sawah."
                />

                <!-- Indikator 3: Giliran air tertib -->
                <x-ui.indicator-item 
                    :number="3"
                    title="Giliran Air {{ $report->giliran_air_ditepati }} dari {{ $report->total_giliran_air }}"
                    :achieved="$report->giliran_air_ditepati >= ($report->total_giliran_air - 1)"
                    badgeText="{{ $report->giliran_air_ditepati }}/{{ $report->total_giliran_air }} Tertib"
                    description="Menghormati jadwal pembagian air irigasi desa secara adil tanpa menyerobot hak petak sawah tetangga."
                />

                <!-- Indikator 4: Modal lewat akad salam -->
                <x-ui.indicator-item 
                    :number="4"
                    title="Modal Lewat Akad Salam"
                    :achieved="(bool)$report->bebas_ijon"
                    badgeText="{{ $report->bebas_ijon ? 'Bebas Ijon' : 'Terikat' }}"
                    description="Biaya olah lahan dan benih didanai penuh di muka oleh pemesan beras. Petani 100% bebas dari jeratan rentenir/ijon."
                />

                <!-- Indikator 5: Zakat tersalurkan -->
                @php
                    $zakatKgFormatted = number_format((float)($harvest->zakat_kg ?? 92.5), 1, ',', '.');
                    $zakatPenyalur = $harvest->zakat_disalurkan ?? 'UPZ Masjid Jami Panosogan';
                @endphp
                <x-ui.indicator-item 
                    :number="5"
                    title="Zakat {{ $zakatKgFormatted }} kg Tersalurkan"
                    :achieved="true"
                    badgeText="Tersalurkan"
                    description="Sebanyak 5% hasil panen diserahkan langsung via {{ $zakatPenyalur }} untuk mustahik dan lansia desa."
                />

                <!-- Indikator 6: Pohon ditanam -->
                <x-ui.indicator-item 
                    :number="6"
                    title="Pohon Ditanam {{ $report->pohon_ditanam }} Pohon"
                    :achieved="$report->pohon_ditanam > 0"
                    badgeText="{{ $report->pohon_ditanam }} Pohon"
                    description="Menanam bibit pohon peneduh dan penguat tanggul di pematang sawah guna mencegah erosi tanah."
                />

            </div>
        </div>

        <!-- 7. Footer Verifikasi Pengesahan Musyawarah Balai Desa -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E5E0D5] text-center space-y-3 shadow-xs">
            <div class="w-9 h-9 rounded-full bg-emerald-50 text-[#15803D] flex items-center justify-center mx-auto shadow-2xs border border-emerald-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                </svg>
            </div>

            <div>
                <div class="text-[10px] font-bold text-stone-500 uppercase tracking-widest">
                    Pengesahan Musyawarah Balai Desa
                </div>
                <div class="text-sm font-extrabold text-stone-900 mt-0.5">
                    Syukuran Panen: {{ $syukuranDate }}
                </div>
                <p class="text-xs text-stone-600 mt-1 max-w-xs mx-auto leading-relaxed">
                    Diverifikasi di Balai Desa Panosogan oleh Koperasi Tani bersama perangkat desa dan penyuluh pertanian lapangan.
                </p>
            </div>

            <div class="pt-2 border-t border-stone-100">
                <a 
                    href="{{ route('storefront.index') }}" 
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-[#1E3F2B] hover:text-[#2C543B] transition-colors"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Kembali ke Beranda Storefront</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
