<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Beras Amanah — Beras pulen segar langsung dari Koperasi Tani Desa Panosogan, Serang. Ditanam dengan akad salam, bebas ijon, dan penuh berkah.">
    
    <title>{{ $title ?? 'Beras Amanah • Koperasi Tani Desa Panosogan, Serang' }}</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-stone-200/80 text-stone-900 antialiased min-h-screen flex flex-col font-sans selection:bg-[#1E3F2B] selection:text-white">

    @if(request()->is('rapor*'))
        <!-- Desktop Navbar for Rapor & Public Pages -->
        <header class="sticky top-0 z-40 bg-[#FAFAF9]/90 backdrop-blur-md border-b border-stone-200/80 transition-all">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-18">
                    <!-- Brand -->
                    <a href="{{ route('storefront.index') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-[#1E3F2B] text-white flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m0-18C8.5 7 5 11 5 16a7 7 0 0014 0c0-5-3.5-9-7-13z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-extrabold text-lg sm:text-xl text-stone-900 tracking-tight leading-none group-hover:text-[#1E3F2B] transition-colors">
                                Beras Amanah
                            </div>
                            <div class="text-[11px] font-medium text-stone-500 tracking-wide mt-0.5">
                                Koperasi Desa Panosogan • Serang
                            </div>
                        </div>
                    </a>

                    <!-- Nav Links -->
                    <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-stone-700">
                        <a href="{{ route('storefront.index') }}" class="hover:text-[#1E3F2B] transition-colors">Beranda</a>
                        <a href="{{ route('storefront.langganan') }}" class="hover:text-[#1E3F2B] transition-colors">Langganan Beras</a>
                        <a href="{{ route('order.check') }}" class="hover:text-[#1E3F2B] transition-colors">Cek Pesanan</a>
                        <a href="{{ route('rapor.show', 'pak-darma-mt1-2027') }}" class="hover:text-[#1E3F2B] transition-colors">Rapor Petani</a>
                    </nav>

                    <!-- Action CTA -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('storefront.langganan') }}" class="inline-flex items-center justify-center font-bold text-xs sm:text-sm bg-[#1E3F2B] hover:bg-[#2C543B] text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl shadow-xs transition-all">
                            Langganan Beras
                        </a>
                    </div>
                </div>
            </div>
        </header>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @if(isset($slot) && $slot->isNotEmpty())
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    @if(request()->is('rapor*'))
        <!-- Desktop Footer for Rapor -->
        <footer class="bg-stone-900 text-stone-300 border-t border-stone-800 mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-16">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                    <div class="md:col-span-2">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-9 h-9 rounded-xl bg-[#1E3F2B] text-white flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m0-18C8.5 7 5 11 5 16a7 7 0 0014 0c0-5-3.5-9-7-13z" />
                                </svg>
                            </div>
                            <span class="font-extrabold text-xl text-white tracking-tight">Beras Amanah</span>
                        </div>
                        <p class="text-sm text-stone-400 max-w-md leading-relaxed">
                            Inisiatif gotong royong Koperasi Tani Desa Panosogan, Kec. Cikeusal, Kab. Serang, Banten. Menghubungkan meja makan keluarga kota langsung dengan sawah petani tanpa perantara ijon, berlandaskan akad salam dan keadilan berkah.
                        </p>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-stone-200 uppercase tracking-wider mb-4">Navigasi Halaman</h4>
                        <ul class="space-y-2.5 text-sm text-stone-400">
                            <li><a href="{{ route('storefront.index') }}" class="hover:text-white transition-colors">Storefront Langganan</a></li>
                            <li><a href="{{ route('order.check') }}" class="hover:text-white transition-colors">Cek Status Pesanan</a></li>
                            <li><a href="{{ route('rapor.show', 'pak-darma-mt1-2027') }}" class="hover:text-white transition-colors">Contoh Rapor QR Pak Darma</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-stone-200 uppercase tracking-wider mb-4">Sekretariat Koperasi</h4>
                        <address class="not-italic text-sm text-stone-400 space-y-2 leading-relaxed">
                            <p>Balai Koperasi Tani Panosogan</p>
                            <p>Desa Panosogan, Kec. Cikeusal</p>
                            <p>Kabupaten Serang, Banten 42175</p>
                            <p class="pt-2 text-emerald-400 font-semibold">WhatsApp: +62 812-3456-7801</p>
                        </address>
                    </div>
                </div>

                <div class="border-t border-stone-800 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-stone-500 gap-4">
                    <p>&copy; {{ date('Y') }} Beras Amanah • Koperasi Tani Desa Panosogan. Hak cipta dilindungi.</p>
                    <p class="italic text-stone-400">“Silih asih, silih asah, silih asuh ti sawah Panosogan.”</p>
                </div>
            </div>
        </footer>
    @endif

    @livewireScripts
</body>
</html>
