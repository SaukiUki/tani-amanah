@extends('layouts.app')

@section('content')
<div class="space-y-16 sm:space-y-24 pb-16">
    
    <!-- 1. Hero Section Hangat -->
    <section class="relative pt-8 sm:pt-14 pb-8 overflow-hidden" id="cerita">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                
                <!-- Left: Headline & Story -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100/80 text-[#15803D] text-xs font-bold border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-[#15803D]"></span>
                        Panen Langsung Musim Tanam MT-1 • Desa Panosogan, Serang
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-stone-900 tracking-tight leading-[1.12]">
                        Beras Pulen Segar, <br class="hidden sm:inline">
                        <span class="text-[#15803D]">Langsung dari Petani</span> Panosogan ke Meja Anda.
                    </h1>

                    <p class="text-base sm:text-lg text-stone-600 leading-relaxed max-w-2xl">
                        Beras varietas Inpari 32 hasil keringat petani Koperasi Desa Panosogan, Serang. Dipetik dari sawah beririgasi tertib, digiling segar tanpa pemutih maupun pengawet, dan dibeli di muka melalui akad salam syariah agar petani bebas dari jeratan ijon rentenir.
                    </p>

                    <!-- Trust Points Row -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-2 border-t border-stone-200/80">
                        <div>
                            <div class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Kualitas Beras</div>
                            <div class="text-sm sm:text-base font-bold text-stone-900 mt-0.5">100% Asli & Pulen</div>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Model Pembelian</div>
                            <div class="text-sm sm:text-base font-bold text-[#15803D] mt-0.5">Akad Salam Berkah</div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Transparansi</div>
                            <div class="text-sm sm:text-base font-bold text-[#D97706] mt-0.5">Rapor QR di Karung</div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-4">
                        <a href="#langganan" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-base font-bold bg-[#15803D] hover:bg-[#166534] text-white shadow-md shadow-emerald-900/10 transition-all cursor-pointer text-center">
                            <span>Mulai Berlangganan Beras</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <a href="#petani" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-base font-bold bg-white hover:bg-stone-50 text-stone-800 border border-stone-300 shadow-2xs transition-all text-center">
                            <span>Kenali Petanimu</span>
                        </a>
                    </div>
                </div>

                <!-- Right: Visual Sawah & Beras Card -->
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        <!-- Main Image Card -->
                        <div class="rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-stone-100 aspect-4/3 relative">
                            <img 
                                src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&q=80&w=800" 
                                alt="Hamparan sawah padi hijau Desa Panosogan Serang" 
                                class="w-full h-full object-cover"
                            >
                            <div class="absolute inset-0 bg-linear-to-t from-stone-950/70 via-transparent to-transparent flex flex-col justify-end p-6 text-white">
                                <span class="text-xs font-semibold uppercase tracking-wider text-amber-300">Hamparan Sawah Blok Cibeber</span>
                                <h3 class="text-lg font-bold">Desa Panosogan, Kec. Cikeusal, Serang</h3>
                                <p class="text-xs text-stone-200 mt-1">27,05 hektar sawah produktif dikelola gotong royong warga desa.</p>
                            </div>
                        </div>

                        <!-- Floating Badge Card -->
                        <div class="absolute -bottom-6 -left-4 sm:-left-6 bg-white rounded-2xl p-4 shadow-xl border border-stone-200/90 max-w-64">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-100 text-[#D97706] flex items-center justify-center font-black text-lg shrink-0">
                                    7k
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold text-stone-500 uppercase">Harga Koperasi</div>
                                    <div class="text-xs font-extrabold text-stone-900 leading-tight">Rp 7.000/kg Gabah</div>
                                    <div class="text-[10px] text-emerald-700 font-semibold">Jauh di atas HPP Pasar</div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating QR Preview Pill -->
                        <div class="absolute -top-4 -right-4 sm:-right-6 bg-white rounded-2xl py-2 px-3.5 shadow-xl border border-stone-200/90 flex items-center gap-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#15803D] animate-ping"></span>
                            <span class="text-xs font-bold text-stone-800">Beras Baru Giling ✨</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 2. Pilihan Paket Langganan Interaktif (Livewire Component) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24" id="langganan">
        <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12">
            <x-ui.badge variant="green" size="md">
                Pilihan Langganan Keluarga
            </x-ui.badge>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-stone-900 tracking-tight mt-3">
                Beras Rutin 10 kg Tiap Bulan
            </h2>
            <p class="text-base text-stone-600 mt-3 leading-relaxed">
                Pilih paket fleksibel bulanan atau bantu langsung modal tanam petani di muka selama 3 bulan dengan akad salam syariah.
            </p>
        </div>

        <!-- Render Livewire SubscriptionCheckout Component -->
        <livewire:storefront.subscription-checkout />
    </section>

    <!-- 3. Teaser Card: Kenali Petanimu (Pak Darma QR) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24" id="petani">
        <div class="rounded-3xl bg-linear-to-br from-emerald-900 to-stone-900 text-white p-8 sm:p-12 relative overflow-hidden shadow-xl">
            <!-- Background Accent Pattern -->
            <div class="absolute top-0 right-0 -mt-12 -mr-12 w-96 h-96 bg-emerald-700/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Farmer Image -->
                <div class="lg:col-span-4 flex justify-center">
                    <div class="relative">
                        <div class="w-48 h-48 sm:w-56 sm:h-56 rounded-3xl overflow-hidden border-4 border-emerald-400/40 shadow-2xl bg-stone-800">
                            <img 
                                src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&q=80&w=400" 
                                alt="Foto Pak Darma Petani Panosogan" 
                                class="w-full h-full object-cover"
                            >
                        </div>
                        <div class="absolute -bottom-3 -right-3 bg-white text-stone-900 py-1.5 px-3 rounded-xl shadow-lg text-xs font-bold flex items-center gap-1.5">
                            <span class="text-emerald-700">✓</span> Rapor Terverifikasi
                        </div>
                    </div>
                </div>

                <!-- Story & Teaser -->
                <div class="lg:col-span-8 space-y-4 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-semibold backdrop-blur-xs">
                        🌾 Kenali Petanimu • Transparansi Rapor Amanah
                    </div>

                    <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                        Pak Darma — Petani Blok Cibeber, Desa Panosogan
                    </h3>

                    <p class="text-sm sm:text-base text-stone-300 leading-relaxed max-w-2xl">
                        Menggarap 0,5 hektar sawah dengan bibit unggul Inpari 32. Pada Musim Tanam MT-1 2027, Pak Darma berhasil memanen 1.850 kg gabah murni, mematuhi 11 dari 12 giliran air desa, mengembalikan jerami ke tanah tanpa dibakar, serta menyalurkan 92,5 kg zakat pertanian melalui UPZ Masjid Jami Panosogan.
                    </p>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a 
                            href="{{ route('rapor.show', 'pak-darma-mt1-2027') }}" 
                            class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-bold text-sm bg-amber-500 hover:bg-amber-400 text-stone-950 shadow-md transition-all cursor-pointer"
                        >
                            <span>Buka Contoh Rapor QR Pak Darma</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        <span class="text-xs text-stone-400">
                            Scan langsung di kemasan karung beras Anda
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. Daftar Dampak Sosial ("Yang Anda Dukung") -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24" id="dampak">
        <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12">
            <x-ui.badge variant="gold" size="md">
                Keadilan & Keberlanjutan
            </x-ui.badge>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-stone-900 tracking-tight mt-3">
                Yang Anda Dukung Lewat Beras Ini
            </h2>
            <p class="text-base text-stone-600 mt-3 leading-relaxed">
                Setiap suap nasi di rumah Anda bukan sekadar makanan lezat, melainkan perlindungan nyata bagi martabat dan masa depan petani desa.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            
            <!-- Dampak 1 -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200/90 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#15803D] flex items-center justify-center font-bold text-xl mb-6 shadow-2xs">
                        💰
                    </div>
                    <h3 class="text-xl font-bold text-stone-900 mb-2">
                        Petani Dibayar Rp 7.000/kg
                    </h3>
                    <p class="text-xs font-semibold text-[#15803D] uppercase tracking-wider mb-3">
                        Di Atas HPP Pasar Tradisional
                    </p>
                    <p class="text-sm text-stone-600 leading-relaxed">
                        Koperasi membeli gabah langsung seharga Rp 7.000/kg (jauh di atas HPP pasar yang sering ditekan tengkulak hingga Rp 5.500-6.000), menjamin pendapatan bersih hingga Rp 8,88 juta per musim bagi keluarga petani.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-stone-100 text-xs font-semibold text-emerald-800">
                    ✓ Nilai tukar petani terlindungi
                </div>
            </div>

            <!-- Dampak 2 -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200/90 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-[#D97706] flex items-center justify-center font-bold text-xl mb-6 shadow-2xs">
                        📜
                    </div>
                    <h3 class="text-xl font-bold text-stone-900 mb-2">
                        Modal Tanam Tanpa Ijon
                    </h3>
                    <p class="text-xs font-semibold text-[#D97706] uppercase tracking-wider mb-3">
                        Skema Syariah Akad Salam
                    </p>
                    <p class="text-sm text-stone-600 leading-relaxed">
                        Uang langganan dibayar di muka dijadikan modal pembelian bibit, pupuk organik, dan traktor. Petani tidak lagi terjebak pinjaman rentenir bunga mencekik sebelum panen dimulai.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-stone-100 text-xs font-semibold text-amber-800">
                    ✓ Bebas riba & hutang modal
                </div>
            </div>

            <!-- Dampak 3 -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200/90 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-stone-100 text-stone-800 flex items-center justify-center font-bold text-xl mb-6 shadow-2xs">
                        🏛️
                    </div>
                    <h3 class="text-xl font-bold text-stone-900 mb-2">
                        Cadangan Leuit Desa
                    </h3>
                    <p class="text-xs font-semibold text-stone-600 uppercase tracking-wider mb-3">
                        Kedaulatan Pangan Lokal
                    </p>
                    <p class="text-sm text-stone-600 leading-relaxed">
                        Sebagian hasil panen disimpan di lumbung leuit desa untuk cadangan pangan warga saat paceklik, serta disalurkan zakat pertaniannya secara tertib melalui UPZ Masjid Jami Panosogan.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-stone-100 text-xs font-semibold text-stone-800">
                    ✓ Lumbung desa & zakat tersalurkan
                </div>
            </div>

        </div>
    </section>

</div>
@endsection
