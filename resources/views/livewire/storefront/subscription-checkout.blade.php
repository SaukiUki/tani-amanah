<div class="max-w-md mx-auto min-h-screen bg-[#F4F1EA] shadow-xl text-stone-900 relative pb-28 border-x border-[#E5E0D5]/70" x-data="{ navOpen: false }">

    <!-- 1. Top Navigation Bar (Mobile-First dengan Hamburger Menu) -->
    <header class="sticky top-0 z-40 bg-[#F4F1EA]/95 backdrop-blur-md border-b border-[#E5E0D5] px-4 py-3 flex items-center justify-between">
        <a href="{{ route('storefront.index') }}" class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-[#1E3F2B] text-white flex items-center justify-center font-bold shadow-xs">
                <!-- Rice Sprout Icon -->
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m0-18C8.5 7 5 11 5 16a7 7 0 0014 0c0-5-3.5-9-7-13z" />
                </svg>
            </div>
            <div>
                <div class="font-extrabold text-base text-[#1E3F2B] leading-none tracking-tight">
                    Beras Amanah
                </div>
                <div class="text-[10px] font-semibold text-stone-500 tracking-wide mt-0.5">
                    Koperasi Desa Panosogan • Serang
                </div>
            </div>
        </a>

        <!-- Hamburger Toggle Button -->
        <button 
            type="button" 
            @click="navOpen = !navOpen" 
            class="w-9 h-9 rounded-xl bg-white border border-[#E5E0D5] flex items-center justify-center text-[#1E3F2B] hover:bg-stone-50 transition-colors shadow-2xs cursor-pointer"
            aria-label="Buka Menu Navigasi"
        >
            <svg x-show="!navOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <svg x-show="navOpen" x-cloak class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </header>

    <!-- Dropdown Menu Navigasi Hamburger -->
    <div 
        x-show="navOpen" 
        x-cloak 
        @click.away="navOpen = false"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="absolute top-15 left-3 right-3 z-50 bg-white rounded-2xl border border-[#E5E0D5] shadow-xl p-3 space-y-1"
    >
        <a 
            href="#paket" 
            @click="navOpen = false" 
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-stone-800 hover:bg-[#E8F3EB] hover:text-[#1E3F2B] transition-colors"
        >
            <span class="w-7 h-7 rounded-lg bg-emerald-50 text-[#1E3F2B] flex items-center justify-center text-sm">🌾</span>
            <span>Langganan Beras</span>
        </a>

        <a 
            href="{{ route('order.check') }}" 
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-stone-800 hover:bg-[#E8F3EB] hover:text-[#1E3F2B] transition-colors"
        >
            <span class="w-7 h-7 rounded-lg bg-emerald-50 text-[#1E3F2B] flex items-center justify-center text-sm">📦</span>
            <span>Cek Status Pesanan</span>
        </a>

        <a 
            href="{{ route('rapor.show', 'pak-darma-mt1-2027') }}" 
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-stone-800 hover:bg-[#E8F3EB] hover:text-[#1E3F2B] transition-colors"
        >
            <span class="w-7 h-7 rounded-lg bg-amber-50 text-[#9A6209] flex items-center justify-center text-sm">📋</span>
            <span>Contoh Rapor Petani (Pak Darma)</span>
        </a>

        <a 
            href="{{ route('whatsapp.simulator') }}" 
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-[#075E54] hover:bg-emerald-50 transition-colors"
        >
            <span class="w-7 h-7 rounded-lg bg-emerald-100 text-[#075E54] flex items-center justify-center text-sm">💬</span>
            <span>Simulasi Bot WA Petani</span>
        </a>

        <div class="border-t border-stone-100 my-1 pt-1">
            <a 
                href="/admin" 
                class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-stone-500 hover:text-stone-900 transition-colors"
            >
                <span class="w-7 h-7 rounded-lg bg-stone-100 text-stone-600 flex items-center justify-center text-xs">⚙️</span>
                <span>Dasbor Koperasi (/admin)</span>
            </a>
        </div>
    </div>

    <!-- 2. Hero Hijau Hutan Editorial (#1E3F2B) -->
    <section class="bg-[#1E3F2B] text-white p-5 pt-6 pb-7 rounded-b-3xl relative overflow-hidden shadow-sm">
        <!-- Accent Glow -->
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-44 h-44 bg-emerald-700/25 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 space-y-3.5">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-[11px] font-bold border border-white/15 backdrop-blur-xs">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                <span>Panen Langsung Musim Tanam MT-1 • Desa Panosogan, Serang</span>
            </div>

            <h1 class="text-2xl font-serif font-extrabold tracking-tight leading-snug">
                Beras Pulen Segar, <br>
                <span class="text-amber-300">Langsung dari Petani</span> Panosogan ke Meja Anda.
            </h1>

            <p class="text-xs text-[#E7E5E4]/90 leading-relaxed">
                Beras varietas Inpari 32 hasil keringat petani Koperasi Desa Panosogan, Serang. Dipetik dari sawah beririgasi tertib, digiling segar tanpa pemutih maupun pengawet, dan dibeli di muka melalui akad salam syariah agar petani bebas dari jeratan ijon rentenir.
            </p>

            <!-- 3 Trust Points Row -->
            <div class="grid grid-cols-3 gap-2 pt-3 border-t border-white/15 text-center">
                <div class="bg-white/5 rounded-xl p-2 border border-white/10">
                    <div class="text-[10px] text-stone-300">Kualitas</div>
                    <div class="text-xs font-bold text-white mt-0.5">100% Asli & Pulen</div>
                </div>
                <div class="bg-white/5 rounded-xl p-2 border border-white/10">
                    <div class="text-[10px] text-stone-300">Model Beli</div>
                    <div class="text-xs font-bold text-amber-300 mt-0.5">Akad Salam Berkah</div>
                </div>
                <div class="bg-white/5 rounded-xl p-2 border border-white/10">
                    <div class="text-[10px] text-stone-300">Transparansi</div>
                    <div class="text-xs font-bold text-white mt-0.5">Rapor QR di Karung</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Seksi Pilihan Paket Beras (Interactive Mobile Cards) -->
    <section class="p-4 pt-6 space-y-4" id="paket">
        <div class="text-center space-y-1 mb-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#E8F3EB] text-[#1E3F2B] border border-[#2C543B]/20">
                Pilihan Langganan Keluarga
            </span>
            <h2 class="text-xl font-serif font-extrabold text-stone-900 tracking-tight">
                Beras Rutin 10 kg Tiap Bulan
            </h2>
            <p class="text-xs text-stone-600">
                Pilih paket fleksibel bulanan atau bantu modal tanam petani di muka selama 3 bulan.
            </p>
        </div>

        <!-- Kartu 1: Bayar per bulan -->
        <div 
            wire:click="selectPlan('monthly')"
            class="relative rounded-2xl p-4.5 cursor-pointer transition-all duration-200 bg-white {{ $selectedPlan === 'monthly' ? 'ring-2 ring-[#1E3F2B] border-2 border-[#1E3F2B] shadow-md' : 'border border-stone-200 hover:border-stone-300' }}"
        >
            @if($selectedPlan === 'monthly')
                <div class="absolute -top-3 right-4">
                    <span class="inline-flex items-center gap-1 bg-[#1E3F2B] text-white font-bold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full shadow-xs">
                        Pilihan Terpilih
                    </span>
                </div>
            @endif

            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold text-stone-600 uppercase tracking-wide">
                    Fleksibel Bulanan
                </span>
                <div class="w-4.5 h-4.5 rounded-full border-2 flex items-center justify-center {{ $selectedPlan === 'monthly' ? 'border-[#1E3F2B] bg-[#1E3F2B]' : 'border-stone-300' }}">
                    @if($selectedPlan === 'monthly')
                        <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                    @endif
                </div>
            </div>

            <h3 class="text-base font-bold text-stone-900">
                Bayar per bulan
            </h3>
            <p class="text-xs text-stone-600 mt-1 leading-relaxed">
                Beras pulen diantar rutin setiap awal bulan, bebas berhenti kapan saja.
            </p>

            <div class="flex items-baseline gap-1.5 mt-3 pt-3 border-t border-stone-100">
                <span class="text-2xl font-extrabold text-stone-900 tabular-nums">
                    Rp 175.000
                </span>
                <span class="text-xs text-stone-500 font-medium">
                    / bulan (10 kg)
                </span>
            </div>

            <ul class="mt-3 space-y-1.5 text-xs text-stone-700">
                <li class="flex items-center gap-2">
                    <span class="text-[#1E3F2B] font-bold">✓</span>
                    <span><strong>10 kg beras pulen</strong> / bulan (2 karung @ 5 kg)</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-[#1E3F2B] font-bold">✓</span>
                    <span>Diantar otomatis setiap awal bulan</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-[#1E3F2B] font-bold">✓</span>
                    <span>QR code rapor transparansi di tiap karung</span>
                </li>
            </ul>
        </div>

        <!-- Kartu 2: 3 bulan dibayar di muka (Default Terpilih) -->
        <div 
            wire:click="selectPlan('quarterly')"
            class="relative rounded-2xl p-4.5 cursor-pointer transition-all duration-200 bg-white {{ $selectedPlan === 'quarterly' ? 'ring-2 ring-[#1E3F2B] border-2 border-[#1E3F2B] shadow-md' : 'border border-stone-200 hover:border-stone-300' }}"
        >
            @if($selectedPlan === 'quarterly')
                <div class="absolute -top-3 right-4">
                    <span class="inline-flex items-center gap-1 bg-[#1E3F2B] text-white font-bold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full shadow-xs">
                        Pilihan Terpilih
                    </span>
                </div>
            @endif

            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold text-[#9A6209] uppercase tracking-wide">
                    Modal Tanam • Akad Salam
                </span>
                <div class="w-4.5 h-4.5 rounded-full border-2 flex items-center justify-center {{ $selectedPlan === 'quarterly' ? 'border-[#1E3F2B] bg-[#1E3F2B]' : 'border-stone-300' }}">
                    @if($selectedPlan === 'quarterly')
                        <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                    @endif
                </div>
            </div>

            <h3 class="text-base font-bold text-stone-900">
                3 bulan dibayar di muka
            </h3>
            <p class="text-xs text-stone-600 mt-1 leading-relaxed">
                Uang Anda langsung jadi <strong>modal tanam petani (Akad Salam)</strong> bebas riba/ijon, beras diantar 10 kg/bulan selama 3 bulan.
            </p>

            <div class="flex items-baseline gap-1.5 mt-3 pt-3 border-t border-stone-100">
                <span class="text-2xl font-extrabold text-[#1E3F2B] tabular-nums">
                    Rp 525.000
                </span>
                <span class="text-xs text-stone-500 font-medium">
                    / 3 bulan (total 30 kg)
                </span>
            </div>

            <ul class="mt-3 space-y-1.5 text-xs text-stone-700">
                <li class="flex items-center gap-2">
                    <span class="text-[#1E3F2B] font-bold">✓</span>
                    <span><strong>Total 30 kg beras</strong> (10 kg diantar rutin tiap awal bulan)</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-[#9A6209] font-bold">🌾</span>
                    <span><strong>Rp 414.000 jadi modal tanam</strong> petani di muka bebas ijon</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-[#1E3F2B] font-bold">✓</span>
                    <span>Prioritas alokasi beras panen terbaik dari Panosogan</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-[#1E3F2B] font-bold">✓</span>
                    <span>Akses penuh laporan berkala musim tanam petani</span>
                </li>
            </ul>
        </div>
    </section>

    <!-- 4. Kartu "Kenali Petanimu" (Pak Darma) -->
    <section class="p-4 pt-2">
        <div class="rounded-2xl bg-white border border-[#E5E0D5] p-4.5 shadow-xs space-y-3">
            <div class="flex items-center justify-between">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                    <span>🌾</span> Kenali Petanimu
                </span>
                <span class="text-[11px] font-bold text-stone-500">
                    Transparansi Panen
                </span>
            </div>

            <div class="flex items-center gap-3.5">
                <div class="w-16 h-16 rounded-2xl overflow-hidden bg-stone-100 border-2 border-emerald-200 shrink-0">
                    <img 
                        src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&q=80&w=400" 
                        alt="Foto Pak Darma Petani Panosogan" 
                        class="w-full h-full object-cover"
                    >
                </div>
                <div class="min-w-0 flex-1">
                    <div class="inline-block text-[10px] font-bold text-[#1E3F2B] bg-[#E8F3EB] px-2 py-0.5 rounded-full mb-1">
                        ✓ Rapor Terverifikasi
                    </div>
                    <h3 class="text-sm font-extrabold text-stone-900 leading-tight">
                        Pak Darma — Petani Blok Cibeber, Desa Panosogan
                    </h3>
                    <p class="text-[11px] text-stone-500 mt-0.5">
                        Menggarap 0,50 ha sawah irigasi Inpari 32 dengan amanah gotong royong.
                    </p>
                </div>
            </div>

            <a 
                href="{{ route('rapor.show', 'pak-darma-mt1-2027') }}" 
                class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl font-bold text-xs bg-[#E8F3EB] hover:bg-emerald-100 text-[#1E3F2B] border border-[#2C543B]/20 transition-colors"
            >
                <span>Lihat Rapor Amanah Petani (pak-darma-mt1-2027)</span>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
    </section>

    <!-- 5. Seksi Dampak Sosial ("Yang Anda Dukung") -->
    <section class="p-4 pt-2 pb-6 space-y-3">
        <div class="text-center">
            <h3 class="text-base font-serif font-extrabold text-stone-900">
                Yang Anda Dukung
            </h3>
            <p class="text-xs text-stone-600 mt-0.5">
                Setiap butir beras menjamin kesejahteraan petani dan cadangan pangan desa.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-2.5">
            <div class="bg-white rounded-xl p-3 border border-stone-200 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-[#1E3F2B] flex items-center justify-center font-bold text-sm shrink-0">
                    7k
                </div>
                <div>
                    <div class="text-xs font-bold text-stone-900">Petani Dibayar Rp 7.000/kg</div>
                    <div class="text-[11px] text-stone-500">Jauh di atas HPP Pasar Gabah (Rp 6.500)</div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-3 border border-stone-200 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-[#9A6209] flex items-center justify-center text-lg shrink-0">
                    ⚖️
                </div>
                <div>
                    <div class="text-xs font-bold text-stone-900">Modal Tanam Tanpa Ijon</div>
                    <div class="text-[11px] text-stone-500">Akad Salam Syariah memberi modal di muka</div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-3 border border-stone-200 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-stone-100 text-stone-700 flex items-center justify-center text-lg shrink-0">
                    🛖
                </div>
                <div>
                    <div class="text-xs font-bold text-stone-900">Cadangan Leuit Desa</div>
                    <div class="text-[11px] text-stone-500">Stok pangan darurat & perlindungan warga desa</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Sticky Bottom Action Bar (Mobile-First) -->
    <div class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-white/95 backdrop-blur-md border-t border-[#E5E0D5] px-4 py-3.5 flex items-center justify-between z-40 shadow-lg">
        <div>
            <div class="text-[10px] font-bold text-[#9A6209] uppercase tracking-wider">
                {{ $selectedPlan === 'quarterly' ? 'Paket 3 Bulan di Muka' : 'Paket Bulanan' }}
            </div>
            <div class="text-xl font-extrabold text-[#1E3F2B] tabular-nums leading-none mt-0.5">
                Rp {{ number_format($this->selectedPrice, 0, ',', '.') }}
            </div>
        </div>

        <button 
            type="button" 
            wire:click="openCheckout"
            class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl font-extrabold text-sm bg-[#1E3F2B] hover:bg-[#2C543B] text-white shadow-md shadow-emerald-950/15 transition-all cursor-pointer"
        >
            <span>Langganan sekarang</span>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </button>
    </div>

    <!-- 7. Modal / Drawer Checkout Pelanggan (Estetika Krem #F4F1EA & Hijau #1E3F2B) -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div 
                wire:click="closeModal"
                class="fixed inset-0 bg-stone-900/60 backdrop-blur-xs transition-opacity"
            ></div>

            <div class="min-h-full flex items-center justify-center p-3 sm:p-4 text-center">
                <div class="relative transform overflow-hidden rounded-3xl bg-[#F4F1EA] text-left shadow-2xl transition-all w-full max-w-md border border-[#E5E0D5] my-6">
                    
                    <!-- Header Modal -->
                    <div class="px-5 py-3.5 border-b border-[#E5E0D5] flex items-center justify-between bg-white/70">
                        <div>
                            <span class="text-[11px] font-bold text-[#1E3F2B] uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#1E3F2B]"></span>
                                Koperasi Tani Desa Panosogan
                            </span>
                            <h3 class="text-base sm:text-lg font-extrabold text-[#1E3F2B] font-serif mt-0.5">
                                {{ $isSuccess ? 'Instruksi Pembayaran' : 'Form Pengiriman & Checkout' }}
                            </h3>
                        </div>
                        <button 
                            type="button" 
                            wire:click="closeModal"
                            class="text-stone-400 hover:text-stone-700 rounded-lg p-1.5 transition-colors cursor-pointer"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="p-5 max-h-[85vh] overflow-y-auto">
                        @if(!$isSuccess)
                            <!-- Ringkasan Paket Terpilih -->
                            <div class="mb-4 p-3.5 rounded-2xl bg-white border border-[#E5E0D5] flex items-center justify-between shadow-2xs">
                                <div>
                                    <div class="text-[10px] font-bold text-[#9A6209] uppercase tracking-wider">Paket Dipilih:</div>
                                    <div class="text-xs font-bold text-stone-900 mt-0.5">
                                        {{ $this->selectedPlanName }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[10px] text-stone-500">Total:</div>
                                    <div class="text-base font-extrabold text-[#1E3F2B] tabular-nums">
                                        Rp {{ number_format($this->selectedPrice, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Form Input Pelanggan -->
                            <form wire:submit.prevent="checkout" class="space-y-3.5">
                                <div>
                                    <label for="customer_name" class="block text-[11px] font-bold text-stone-800 uppercase tracking-wider mb-1">
                                        Nama Lengkap <span class="text-rose-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="customer_name" 
                                        wire:model="customer_name"
                                        placeholder="Contoh: Budi Santoso"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-stone-300 focus:border-[#1E3F2B] focus:ring-2 focus:ring-[#1E3F2B]/20 text-xs transition-all text-stone-900"
                                    >
                                    @error('customer_name')
                                        <p class="text-[11px] text-rose-600 mt-0.5 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_phone" class="block text-[11px] font-bold text-stone-800 uppercase tracking-wider mb-1">
                                        Nomor WhatsApp <span class="text-rose-500">*</span>
                                    </label>
                                    <input 
                                        type="tel" 
                                        id="customer_phone" 
                                        wire:model="customer_phone"
                                        placeholder="Contoh: 081234567890"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-stone-300 focus:border-[#1E3F2B] focus:ring-2 focus:ring-[#1E3F2B]/20 text-xs transition-all text-stone-900"
                                    >
                                    <p class="text-[10px] text-stone-500 mt-0.5">Konfirmasi & tracking kiriman beras dikirim ke nomor ini.</p>
                                    @error('customer_phone')
                                        <p class="text-[11px] text-rose-600 mt-0.5 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="city" class="block text-[11px] font-bold text-stone-800 uppercase tracking-wider mb-1">
                                        Wilayah Pengiriman <span class="text-rose-500">*</span>
                                    </label>
                                    <select 
                                        id="city" 
                                        wire:model="city"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-stone-300 focus:border-[#1E3F2B] focus:ring-2 focus:ring-[#1E3F2B]/20 text-xs transition-all text-stone-900 font-medium"
                                    >
                                        <option value="Serang">Serang (Kota & Kab. Serang)</option>
                                        <option value="Cilegon">Cilegon (Kota Cilegon)</option>
                                        <option value="Tangerang">Tangerang (Kota Tangerang & Tangsel)</option>
                                        <option value="Jakarta">Jakarta (DKI Jakarta)</option>
                                    </select>
                                    @error('city')
                                        <p class="text-[11px] text-rose-600 mt-0.5 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="delivery_address" class="block text-[11px] font-bold text-stone-800 uppercase tracking-wider mb-1">
                                        Alamat Lengkap Pengiriman <span class="text-rose-500">*</span>
                                    </label>
                                    <textarea 
                                        id="delivery_address" 
                                        wire:model="delivery_address"
                                        rows="2"
                                        placeholder="Nama Jalan, Nomor Rumah, RT/RW, Kelurahan, Kecamatan"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-stone-300 focus:border-[#1E3F2B] focus:ring-2 focus:ring-[#1E3F2B]/20 text-xs transition-all text-stone-900"
                                    ></textarea>
                                    @error('delivery_address')
                                        <p class="text-[11px] text-rose-600 mt-0.5 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-[11px] font-bold text-stone-800 uppercase tracking-wider mb-1.5">
                                        Metode Pembayaran <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <label class="relative flex flex-col p-2.5 rounded-xl border cursor-pointer transition-all bg-white {{ $payment_method === 'qris' ? 'border-[#1E3F2B] ring-2 ring-[#1E3F2B]/20 shadow-xs' : 'border-stone-200' }}">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-bold text-stone-900">QRIS</span>
                                                <input type="radio" wire:model="payment_method" value="qris" class="text-[#1E3F2B] focus:ring-[#1E3F2B]">
                                            </div>
                                            <span class="text-[10px] text-stone-500 mt-0.5">Semua E-Wallet / Bank</span>
                                        </label>

                                        <label class="relative flex flex-col p-2.5 rounded-xl border cursor-pointer transition-all bg-white {{ $payment_method === 'va' ? 'border-[#1E3F2B] ring-2 ring-[#1E3F2B]/20 shadow-xs' : 'border-stone-200' }}">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-bold text-stone-900">VA BSI</span>
                                                <input type="radio" wire:model="payment_method" value="va" class="text-[#1E3F2B] focus:ring-[#1E3F2B]">
                                            </div>
                                            <span class="text-[10px] text-stone-500 mt-0.5">Bank Syariah Indonesia</span>
                                        </label>
                                    </div>
                                    @error('payment_method')
                                        <p class="text-[11px] text-rose-600 mt-0.5 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="pt-2">
                                    <button 
                                        type="submit" 
                                        wire:loading.attr="disabled"
                                        class="w-full py-3 px-4 rounded-xl font-bold text-xs bg-[#1E3F2B] hover:bg-[#2C543B] text-white shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
                                    >
                                        <span wire:loading.remove>Konfirmasi Pesanan & Lanjut Bayar</span>
                                        <span wire:loading class="inline-flex items-center gap-2">
                                            <svg class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                            </svg>
                                            Memproses pesanan...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        @else
                            <!-- Layar Tagihan & Pembayaran -->
                            <div class="text-center space-y-3.5">
                                <div class="w-12 h-12 rounded-full bg-amber-100 text-[#9A6209] mx-auto flex items-center justify-center shadow-xs">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>

                                <div>
                                    <span class="text-[11px] font-bold text-amber-800 bg-amber-100 px-3 py-0.5 rounded-full border border-amber-300">
                                        Status: Menunggu Pembayaran
                                    </span>
                                    <h4 class="text-lg font-serif font-extrabold text-[#1E3F2B] mt-2">
                                        Pesanan Berhasil Dicatat!
                                    </h4>
                                    <p class="text-xs text-stone-500 mt-0.5">
                                        Nomor Invoice: <span class="font-mono font-bold text-stone-900 bg-white px-2 py-0.5 rounded border border-stone-200">{{ $submittedSubscription?->invoice_number }}</span>
                                    </p>
                                </div>

                                <!-- Ringkasan & Alokasi Modal Salam -->
                                <div class="bg-white rounded-2xl p-3.5 border border-[#E5E0D5] text-left text-xs space-y-1.5 shadow-2xs">
                                    <div class="flex justify-between">
                                        <span class="text-stone-500">Nama Pelanggan:</span>
                                        <span class="font-bold text-stone-800">{{ $submittedSubscription?->customer_name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-stone-500">Wilayah:</span>
                                        <span class="font-semibold text-stone-800">{{ $submittedSubscription?->city }}</span>
                                    </div>

                                    <!-- Alokasi Modal Tanam ke Desa Panosogan -->
                                    <div class="mt-2 pt-2 border-t border-stone-100 bg-[#E8F3EB] -mx-3.5 px-3.5 py-2 text-[#1E3F2B]">
                                        <div class="flex items-center justify-between font-bold text-[11px]">
                                            <span>Rincian Alokasi Modal Tanam ke Desa Panosogan:</span>
                                            <span class="tabular-nums">Rp {{ number_format((float)($submittedSubscription?->salam_allocation_amount ?? 0), 0, ',', '.') }}</span>
                                        </div>
                                        <p class="text-[10px] text-stone-600 mt-0.5 leading-snug">
                                            @if(($submittedSubscription?->salam_allocation_amount ?? 0) > 0)
                                                Dana modal Rp 13.800/kg × 30 kg diserahkan di muka kepada petani Panosogan untuk olah lahan, benih, dan pupuk berimbang bebas ijon.
                                            @else
                                                Paket reguler bulanan: Beras 10 kg diantar awal bulan langsung dari lumbung panen koperasi.
                                            @endif
                                        </p>
                                    </div>

                                    <div class="flex justify-between border-t border-stone-200 pt-2 font-bold text-xs">
                                        <span class="text-stone-800">Total Tagihan:</span>
                                        <span class="text-[#1E3F2B] tabular-nums text-sm">Rp {{ number_format((float)($submittedSubscription?->total_amount ?? $this->selectedPrice), 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <!-- Box Pembayaran QRIS / VA -->
                                <div class="p-3.5 rounded-2xl border-2 border-dashed border-[#E5E0D5] bg-white/70 space-y-2.5">
                                    <div class="text-[11px] font-bold text-[#1E3F2B] uppercase tracking-wider">
                                        Pilihan Pembayaran Resmi Koperasi
                                    </div>

                                    @if($payment_method === 'qris')
                                        <div class="bg-white p-3 rounded-xl border border-stone-200 inline-block mx-auto shadow-xs">
                                            <div class="text-[10px] font-bold text-[#1E3F2B] mb-1">QRIS • Koperasi Tani Panosogan</div>
                                            <div class="w-36 h-36 bg-stone-50 rounded-lg flex flex-col items-center justify-center p-2 border border-stone-200 mx-auto">
                                                <svg class="w-24 h-24 text-stone-900" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zm10-2h8v8h-8V2zm2 2v4h4V4h-4zM2 14h8v8H2v-8zm2 2v4h4v-4H4zm14 2h2v2h-2v-2zm-4-2h2v2h-2v-2zm2 4h2v2h-2v-2zm4-4h2v6h-2v-6zm-4 4h-2v-2h2v2zm-2-4h2v2h-2v-2zm6-2h2v2h-2v-2z"/>
                                                </svg>
                                                <span class="text-[9px] text-stone-600 font-mono mt-0.5">Scan via Semua E-Wallet / Bank</span>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Virtual Account BSI -->
                                    <div class="text-left bg-white p-2.5 rounded-xl border border-stone-200 text-xs">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-stone-800 text-[11px]">Virtual Account BSI (Bank Syariah)</span>
                                            <span class="text-[9px] bg-emerald-100 text-emerald-800 px-1.5 py-0.5 rounded font-mono font-bold">BSI</span>
                                        </div>
                                        <div class="mt-1 flex items-center justify-between bg-[#F4F1EA] px-2.5 py-1.5 rounded-lg border border-[#E5E0D5]">
                                            <span class="font-mono font-bold text-stone-900 text-xs tracking-wide">
                                                7701 0812 {{ str_pad((string)($submittedSubscription?->id ?? 1), 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                            <span class="text-[10px] text-[#1E3F2B] font-semibold">a.n. Koperasi Panosogan</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Simulasi Pembayaran Berhasil (Redirects to /pesanan/{invoice_number}) -->
                                <div class="pt-1 space-y-2">
                                    <button 
                                        type="button" 
                                        wire:click="simulatePaymentSuccess"
                                        wire:loading.attr="disabled"
                                        class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-extrabold text-xs bg-emerald-600 hover:bg-emerald-700 text-white shadow-md transition-all cursor-pointer"
                                    >
                                        <svg class="w-4 h-4 text-emerald-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                        </svg>
                                        <span>Simulasi Pembayaran Berhasil</span>
                                    </button>

                                    @php
                                        $waText = urlencode("Halo Koperasi Tani Panosogan, saya memesan Beras Amanah dengan Invoice: " . ($submittedSubscription?->invoice_number ?? '') . " atas nama " . ($submittedSubscription?->customer_name ?? '') . ". Mohon konfirmasi pesanan.");
                                    @endphp
                                    <a 
                                        href="https://wa.me/6281234567801?text={{ $waText }}" 
                                        target="_blank"
                                        class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl font-bold text-[11px] bg-white hover:bg-stone-50 text-stone-800 border border-stone-300 transition-colors"
                                    >
                                        <svg class="w-3.5 h-3.5 fill-emerald-600" viewBox="0 0 24 24">
                                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                                        </svg>
                                        Konfirmasi via WhatsApp Admin
                                    </a>

                                    <button 
                                        type="button" 
                                        wire:click="resetForm"
                                        class="w-full py-2 px-3 rounded-xl font-medium text-[11px] text-stone-600 hover:text-stone-900 bg-stone-100 hover:bg-stone-200 transition-colors cursor-pointer"
                                    >
                                        Tutup & Selesai
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
