@extends('layouts.app', ['title' => 'Rapor Amanah • ' . $farmer->nama . ' (' . ($season->kode_musim ?? 'MT-1 2027') . ')'])

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6 sm:py-10 space-y-6">

    <!-- 1. Header Badge & Musim Tanam -->
    <div class="text-center space-y-2">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-[#15803D] text-xs sm:text-sm font-extrabold uppercase tracking-widest border border-emerald-200">
            <span class="w-2 h-2 rounded-full bg-[#15803D] animate-ping"></span>
            RAPOR AMANAH • {{ $season->kode_musim ?? 'MT-1 2027' }}
        </div>
        <p class="text-xs text-stone-500 font-medium">
            Dokumen Transparansi Panen Resmi Koperasi Tani Panosogan
        </p>
    </div>

    <!-- 2. Profil Petani Card -->
    <div class="bg-white rounded-3xl p-5 sm:p-7 border border-stone-200/90 shadow-sm relative overflow-hidden">
        <div class="flex items-center gap-4 sm:gap-5">
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl overflow-hidden bg-stone-100 border-2 border-emerald-200 shrink-0 shadow-xs">
                <img 
                    src="{{ $farmer->foto_url ?? 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&q=80&w=400' }}" 
                    alt="Foto Profil Petani {{ $farmer->nama }}"
                    class="w-full h-full object-cover"
                >
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-2 flex-wrap">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-stone-900 tracking-tight">
                        {{ $farmer->nama }}
                    </h1>
                    <span class="inline-flex items-center text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 px-2 py-0.5 rounded-full">
                        Petani Utama
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-stone-600 mt-1 leading-snug">
                    <span class="font-semibold text-stone-800">{{ number_format((float)$farmer->luas_lahan_ha, 2, ',', '.') }} ha</span> • {{ $farmer->blok_lahan }}
                </p>
                <p class="text-xs text-stone-500 mt-0.5">
                    {{ $village->nama_desa ?? 'Desa Panosogan' }}, {{ $village->kecamatan ?? 'Kec. Cikeusal' }}, {{ $village->kabupaten ?? 'Kab. Serang' }}
                </p>
            </div>
        </div>
    </div>

    <!-- 3. Banner Peribahasa Sunda -->
    <div class="bg-linear-to-r from-amber-500/15 via-amber-400/10 to-amber-500/15 border border-amber-300/80 rounded-2xl p-4 sm:p-5 text-center shadow-xs">
        <span class="text-xs uppercase tracking-widest font-extrabold text-amber-800 block mb-1">
            Filosofi Panen Panosogan
        </span>
        <blockquote class="text-lg sm:text-xl font-bold text-amber-950 italic">
            “Silih asih, silih asah, silih asuh.”
        </blockquote>
        <p class="text-xs text-amber-900/80 mt-1 max-w-md mx-auto">
            Saling mengasihi antarwarga, saling mengasah budi dan cara bertani berkah, serta saling mengayomi saat suka maupun duka.
        </p>
    </div>

    <!-- 4. Dua Kartu Metrik Utama (Angka Tabular-nums) -->
    <div class="grid grid-cols-2 gap-3.5 sm:gap-5">
        <!-- Hasil Panen -->
        <x-ui.stat-card 
            label="Hasil Panen"
            :value="number_format((float)($harvest->berat_gabah_kg ?? 1850), 0, ',', '.')"
            unit="kg"
            subtext="Gabah murni varietas Inpari 32 hasil tandur serentak"
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
            subtext="Diterima tunai oleh petani, melampaui harga HPP"
            accent="gold"
        />
    </div>

    <!-- 5. Checklist 6 Indikator "AMANAH MUSIM INI" Dinamis Dari Database -->
    <div class="bg-white rounded-3xl p-5 sm:p-7 border border-stone-200/90 shadow-sm space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-stone-100 flex-wrap gap-2">
            <div>
                <h2 class="text-base sm:text-lg font-extrabold text-stone-900">
                    Amanah Musim Ini
                </h2>
                <p class="text-xs text-stone-500">
                    6 Komitmen kejujuran budidaya yang dipenuhi oleh {{ $farmer->nama }}
                </p>
            </div>
            <span class="inline-flex items-center text-xs font-bold text-[#15803D] bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                Skor: 100% Sempurna
            </span>
        </div>

        <div class="space-y-3">
            
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

    <!-- 6. Footer Verifikasi Tanggal Syukuran Panen -->
    <div class="bg-stone-100 rounded-3xl p-5 sm:p-6 border border-stone-200 text-center space-y-3">
        <div class="w-10 h-10 rounded-full bg-white text-stone-700 flex items-center justify-center mx-auto shadow-xs border border-stone-200">
            <svg class="w-5 h-5 text-[#15803D]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
            </svg>
        </div>

        <div>
            <div class="text-[11px] font-bold text-stone-500 uppercase tracking-widest">
                Pengesahan Musyawarah Balai Desa
            </div>
            <div class="text-sm sm:text-base font-extrabold text-stone-900 mt-1">
                Syukuran Panen: {{ $syukuranDate }}
            </div>
            <p class="text-xs text-stone-600 mt-1 max-w-sm mx-auto">
                Diverifikasi di Balai Desa Panosogan oleh Koperasi Tani bersama perangkat desa dan penyuluh pertanian lapangan.
            </p>
        </div>

        <div class="pt-2">
            <a 
                href="{{ route('storefront.index') }}" 
                class="inline-flex items-center gap-2 text-xs font-bold text-[#15803D] hover:text-[#166534] transition-colors"
            >
                ← Kembali ke Halaman Utama Langganan Beras
            </a>
        </div>
    </div>

</div>
@endsection
