<div class="max-w-md mx-auto min-h-screen bg-[#F4F1EA] shadow-xl text-stone-900 relative pb-16 border-x border-[#E5E0D5]/70">

    <!-- 1. Top Bar -->
    <header class="sticky top-0 z-40 bg-[#F4F1EA]/95 backdrop-blur-md border-b border-[#E5E0D5] px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <a href="{{ route('storefront.index') }}" class="w-8 h-8 rounded-xl bg-white border border-[#E5E0D5] flex items-center justify-center text-stone-700 hover:text-[#1E3F2B] transition-colors shadow-2xs">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="font-extrabold text-sm text-[#1E3F2B] leading-none">
                    Portal Pelanggan
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
            + Langganan Baru
        </a>
    </header>

    <div class="p-4 space-y-4">
        @if($subscription)
            <!-- MODE 1: DETAIL PESANAN AKTIF (/pesanan/{invoice_number}) -->
            
            <!-- 1. Card Status & Identitas Langganan -->
            <div class="bg-white rounded-2xl p-4.5 border border-[#E5E0D5] shadow-xs space-y-3">
                <div class="flex items-center justify-between gap-2">
                    @if($subscription->payment_status === 'paid')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-900 border border-emerald-300">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                            Aktif • Modal Akad Salam Tersalurkan
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-amber-100 text-amber-900 border border-amber-300">
                            Menunggu Pembayaran
                        </span>
                    @endif

                    <span class="text-[11px] font-mono text-stone-500">
                        {{ $subscription->created_at?->format('d M Y') ?? date('d M Y') }}
                    </span>
                </div>

                <div class="pt-1">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-stone-500 block">Nomor Invoice</span>
                    <div class="text-base font-mono font-extrabold text-[#1E3F2B]">
                        {{ $subscription->invoice_number }}
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 pt-2 border-t border-stone-100 text-xs">
                    <div>
                        <span class="text-[10px] text-stone-500 block">Penerima Beras:</span>
                        <span class="font-bold text-stone-900">{{ $subscription->customer_name }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-stone-500 block">WhatsApp:</span>
                        <span class="font-bold text-stone-900 font-mono">{{ $subscription->customer_phone }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-[10px] text-stone-500 block">Tujuan Pengiriman:</span>
                        <span class="text-stone-800 leading-snug block mt-0.5">
                            {{ $subscription->delivery_address }} ({{ $subscription->city }})
                        </span>
                    </div>
                    <div class="col-span-2 pt-2 border-t border-stone-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-stone-500 block">Paket Langganan:</span>
                            <span class="font-extrabold text-stone-900">
                                {{ $subscription->plan_type === 'quarterly' ? 'Paket Musiman (3 Bulan / 30 kg)' : 'Paket Bulanan (1 Bulan / 10 kg)' }}
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-stone-500 block">Total:</span>
                            <span class="font-extrabold text-[#1E3F2B] tabular-nums text-sm">
                                Rp {{ number_format((float)$subscription->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Jadwal Pengiriman Beras (10 kg / bulan) -->
            <div class="bg-white rounded-2xl p-4.5 border border-[#E5E0D5] shadow-xs space-y-3.5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-serif font-extrabold text-[#1E3F2B]">
                            Jadwal Pengiriman Beras (10 kg / bulan)
                        </h2>
                        <p class="text-[11px] text-stone-500">
                            Diantar otomatis ke alamat Anda setiap awal bulan.
                        </p>
                    </div>
                    <span class="w-7 h-7 rounded-lg bg-emerald-50 text-[#1E3F2B] flex items-center justify-center text-sm font-bold">
                        🚚
                    </span>
                </div>

                <!-- Timeline 3 Pengiriman Bulanan -->
                <div class="space-y-2.5">
                    <!-- Bulan 1 -->
                    <div class="p-3 rounded-xl border border-emerald-200 bg-emerald-50/60 flex items-start justify-between gap-3">
                        <div class="flex items-start gap-2.5">
                            <span class="w-6 h-6 rounded-full bg-[#1E3F2B] text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">
                                1
                            </span>
                            <div>
                                <div class="text-xs font-extrabold text-stone-900">
                                    Pengiriman Bulan 1 • 10 kg Beras Pulen
                                </div>
                                <div class="text-[11px] text-stone-600 mt-0.5">
                                    2 kemasan @ 5 kg • Varietas Inpari 32
                                </div>
                                <div class="text-[10px] text-stone-500 mt-0.5">
                                    Estimasi: Awal Bulan Pertama
                                </div>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-200/80 text-emerald-950 shrink-0">
                            Sedang Dikemas / Siap Kirim
                        </span>
                    </div>

                    @if($subscription->duration_months >= 3 || $subscription->plan_type === 'quarterly')
                        <!-- Bulan 2 -->
                        <div class="p-3 rounded-xl border border-stone-200 bg-stone-50/70 flex items-start justify-between gap-3">
                            <div class="flex items-start gap-2.5">
                                <span class="w-6 h-6 rounded-full bg-stone-200 text-stone-700 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">
                                    2
                                </span>
                                <div>
                                    <div class="text-xs font-bold text-stone-900">
                                        Pengiriman Bulan 2 • 10 kg Beras Pulen
                                    </div>
                                    <div class="text-[11px] text-stone-600 mt-0.5">
                                        2 kemasan @ 5 kg • Varietas Inpari 32
                                    </div>
                                    <div class="text-[10px] text-stone-500 mt-0.5">
                                        Estimasi: Awal Bulan Kedua
                                    </div>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-stone-200/70 text-stone-700 shrink-0">
                                Terjadwal Rutin
                            </span>
                        </div>

                        <!-- Bulan 3 -->
                        <div class="p-3 rounded-xl border border-stone-200 bg-stone-50/70 flex items-start justify-between gap-3">
                            <div class="flex items-start gap-2.5">
                                <span class="w-6 h-6 rounded-full bg-stone-200 text-stone-700 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">
                                    3
                                </span>
                                <div>
                                    <div class="text-xs font-bold text-stone-900">
                                        Pengiriman Bulan 3 • 10 kg Beras Pulen
                                    </div>
                                    <div class="text-[11px] text-stone-600 mt-0.5">
                                        2 kemasan @ 5 kg • Varietas Inpari 32
                                    </div>
                                    <div class="text-[10px] text-stone-500 mt-0.5">
                                        Estimasi: Awal Bulan Ketiga
                                    </div>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-stone-200/70 text-stone-700 shrink-0">
                                Terjadwal Rutin
                            </span>
                        </div>
                    @endif
                </div>

                <div class="p-2.5 rounded-xl bg-[#F4F1EA] border border-[#E5E0D5] text-[11px] text-stone-600 flex items-center gap-2">
                    <span class="text-sm">🏷️</span>
                    <span>Setiap karung beras dilengkapi stiker QR Code Rapor Panen untuk melacak tanggal giling dan asal petak sawah.</span>
                </div>
            </div>

            <!-- 3. Jejak Dampak & Petani Mitra (Pak Darma, Blok Cibeber) -->
            <div class="bg-white rounded-2xl p-4.5 border border-[#E5E0D5] shadow-xs space-y-3.5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-serif font-extrabold text-[#1E3F2B]">
                            Jejak Dampak &amp; Petani Mitra
                        </h2>
                        <p class="text-[11px] text-stone-500">
                            Petani Desa Panosogan yang Anda dukung langsung.
                        </p>
                    </div>
                    <span class="w-7 h-7 rounded-lg bg-amber-50 text-[#9A6209] flex items-center justify-center text-sm">
                        🌾
                    </span>
                </div>

                <div class="p-3.5 rounded-xl bg-[#E8F3EB]/60 border border-[#2C543B]/20 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 rounded-2xl overflow-hidden bg-stone-100 border-2 border-emerald-300 shrink-0">
                            <img 
                                src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&q=80&w=400" 
                                alt="Foto Pak Darma Petani Panosogan" 
                                class="w-full h-full object-cover"
                            >
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="inline-block text-[10px] font-bold text-[#1E3F2B] bg-white px-2 py-0.5 rounded-full shadow-2xs">
                                ✓ Petani Mitra Terverifikasi
                            </div>
                            <h3 class="text-sm font-bold text-stone-900 mt-1">
                                Pak Darma
                            </h3>
                            <p class="text-[11px] text-stone-600">
                                Blok Cibeber, Desa Panosogan, Serang (0,50 ha)
                            </p>
                        </div>
                    </div>

                    <p class="text-xs text-stone-700 leading-relaxed border-t border-emerald-200/60 pt-2.5">
                        Dari paket langganan Anda, modal sebesar 
                        <strong class="text-[#1E3F2B]">Rp {{ number_format((float)($subscription->salam_allocation_amount ?? 414000), 0, ',', '.') }}</strong>
                        diterima penuh di muka oleh Pak Darma dan petani Panosogan untuk benih Inpari 32, olah lahan, dan pupuk organik bebas ijon rentenir.
                    </p>

                    <!-- Tombol Lihat Rapor Amanah Petani -->
                    <a 
                        href="{{ route('rapor.show', 'pak-darma-mt1-2027') }}" 
                        class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl font-bold text-xs bg-[#1E3F2B] hover:bg-[#2C543B] text-white shadow-xs transition-colors"
                    >
                        <span>Lihat Rapor Amanah Petani (Pak Darma)</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Tombol Aksi Bawah -->
            <div class="pt-2 flex flex-col gap-2">
                <a 
                    href="{{ route('order.check') }}" 
                    class="w-full py-2.5 px-4 rounded-xl font-bold text-xs text-stone-700 bg-white border border-stone-200 hover:bg-stone-50 transition-colors text-center"
                >
                    Cek Nomor Pesanan Lain
                </a>
                <a 
                    href="{{ route('storefront.index') }}" 
                    class="w-full py-2.5 px-4 rounded-xl font-semibold text-xs text-stone-500 hover:text-stone-800 transition-colors text-center"
                >
                    Kembali ke Beranda Storefront
                </a>
            </div>

        @else
            <!-- MODE 2: FORM PENCARIAN PESANAN (/cek-pesanan) -->
            <div class="bg-white rounded-2xl p-5 border border-[#E5E0D5] shadow-xs space-y-4">
                <div class="text-center space-y-1">
                    <div class="w-12 h-12 rounded-2xl bg-[#E8F3EB] text-[#1E3F2B] mx-auto flex items-center justify-center text-2xl font-bold mb-2">
                        📦
                    </div>
                    <h2 class="text-base font-serif font-extrabold text-[#1E3F2B]">
                        Cek Status Pesanan &amp; Pengiriman
                    </h2>
                    <p class="text-xs text-stone-600 leading-relaxed max-w-xs mx-auto">
                        Masukkan Nomor Invoice atau Nomor WhatsApp untuk melihat jadwal pengiriman beras dan jejak modal tanam petani.
                    </p>
                </div>

                <form wire:submit.prevent="checkOrder" class="space-y-3 pt-1">
                    <div>
                        <label for="query" class="block text-[11px] font-bold text-stone-800 uppercase tracking-wider mb-1.5">
                            Nomor Invoice atau Nomor WhatsApp
                        </label>
                        <input 
                            type="text" 
                            id="query" 
                            wire:model="query"
                            placeholder="Contoh: AMANAH-202701-0001 atau 081234567890"
                            class="w-full px-3.5 py-3 rounded-xl bg-stone-50 border border-stone-300 focus:border-[#1E3F2B] focus:ring-2 focus:ring-[#1E3F2B]/20 text-xs text-stone-900 transition-all font-medium"
                        >
                    </div>

                    @if($errorMessage)
                        <div class="p-3 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700">
                            {{ $errorMessage }}
                        </div>
                    @endif

                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="w-full py-3 px-4 rounded-xl font-extrabold text-xs bg-[#1E3F2B] hover:bg-[#2C543B] text-white shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
                    >
                        <span wire:loading.remove>Cari Status Pesanan</span>
                        <span wire:loading class="inline-flex items-center gap-2">
                            <svg class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Mencari...
                        </span>
                    </button>
                </form>

                <!-- Hasil jika ditemukan lebih dari 1 pesanan dengan No WA yang sama -->
                @if(count($subscriptions) > 1)
                    <div class="pt-3 border-t border-stone-100 space-y-2">
                        <span class="text-xs font-bold text-stone-800 block">Ditemukan {{ count($subscriptions) }} Pesanan:</span>
                        @foreach($subscriptions as $sub)
                            <a 
                                href="{{ route('order.show', $sub->invoice_number) }}" 
                                class="block p-3 rounded-xl border border-stone-200 hover:border-[#1E3F2B] bg-stone-50/50 hover:bg-[#E8F3EB]/30 transition-all text-xs"
                            >
                                <div class="flex justify-between items-center font-mono font-bold text-[#1E3F2B]">
                                    <span>{{ $sub->invoice_number }}</span>
                                    <span class="text-[10px] uppercase font-sans font-bold px-2 py-0.5 rounded-full {{ $sub->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $sub->payment_status === 'paid' ? 'Aktif / Lunas' : 'Menunggu' }}
                                    </span>
                                </div>
                                <div class="text-[11px] text-stone-600 mt-1 flex justify-between">
                                    <span>{{ $sub->plan_type === 'quarterly' ? 'Paket Musiman (30 kg)' : 'Paket Bulanan (10 kg)' }}</span>
                                    <span class="font-bold text-stone-900">Rp {{ number_format((float)$sub->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Bantuan / Hubungi Admin -->
            <div class="rounded-2xl bg-white/70 border border-[#E5E0D5] p-4 text-center space-y-2 text-xs">
                <span class="text-stone-500 block">Butuh bantuan verifikasi pembayaran manual?</span>
                <a 
                    href="https://wa.me/6281234567801?text=Halo%20Admin%20Koperasi%20Panosogan%2C%20saya%20ingin%20cek%20status%20pesanan%20Beras%20Amanah." 
                    target="_blank"
                    class="inline-flex items-center gap-1.5 font-bold text-[#1E3F2B] hover:underline"
                >
                    <svg class="w-3.5 h-3.5 fill-emerald-600" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                    </svg>
                    Hubungi WhatsApp Pengelola Koperasi
                </a>
            </div>
        @endif
    </div>
</div>
