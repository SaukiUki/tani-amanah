<div class="min-h-screen bg-stone-100 py-6 px-3 sm:px-6 lg:px-8 font-sans selection:bg-[#075E54] selection:text-white">
    <div class="max-w-6xl mx-auto space-y-6">

        <!-- 1. Top Bar / Breadcrumb Navigation -->
        <div class="flex flex-wrap items-center justify-between gap-4 pb-2 border-b border-stone-200">
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('storefront.index') }}" 
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-stone-200 text-xs font-bold text-stone-700 hover:text-[#1E3F2B] hover:border-stone-300 shadow-2xs transition-all"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Storefront</span>
                </a>
                <span class="text-stone-300">/</span>
                <span class="text-xs font-extrabold text-[#075E54] uppercase tracking-wider">
                    Simulasi Bot WA Petani
                </span>
            </div>

            <div class="flex items-center gap-2">
                <a 
                    href="/admin" 
                    target="_blank"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#1E3F2B] text-white text-xs font-bold hover:bg-[#2C543B] shadow-2xs transition-all"
                >
                    <span>Dasbor Koperasi (/admin)</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
                <button 
                    type="button" 
                    wire:click="resetChat"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-stone-200 text-xs font-bold text-stone-600 hover:bg-stone-50 shadow-2xs transition-all cursor-pointer"
                    title="Bersihkan percakapan ke kondisi awal"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <span>Reset Chat</span>
                </button>
            </div>
        </div>

        <!-- 2. Main Grid: Phone Simulator & Real-time Koperasi Telemetry -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- PHONE SIMULATOR COLUMN (lg:col-span-7) -->
            <div class="lg:col-span-7 flex flex-col items-center">
                
                <!-- PRESET QUICK ACTION CHIPS (Above Phone) -->
                <div class="w-full max-w-[420px] mb-3">
                    <div class="text-[11px] font-bold text-stone-500 uppercase tracking-wider mb-2 flex items-center justify-between">
                        <span>⚡ Quick-Action Preset Demo (Sekali Klik)</span>
                        <span class="text-[10px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full font-bold">Siap Presentasi</span>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        <button 
                            type="button"
                            wire:click="sendPreset('menu')"
                            class="px-2.5 py-1.5 rounded-lg bg-white border border-stone-200 hover:border-[#075E54] hover:bg-emerald-50 text-stone-800 text-[11px] font-bold shadow-2xs transition-all flex items-center gap-1 cursor-pointer"
                        >
                            <span>📋</span>
                            <span>Kirim: Menu</span>
                        </button>
                        <button 
                            type="button"
                            wire:click="sendPreset('pupuk organik 2 karung 150rb')"
                            class="px-2.5 py-1.5 rounded-lg bg-white border border-stone-200 hover:border-[#075E54] hover:bg-emerald-50 text-stone-800 text-[11px] font-bold shadow-2xs transition-all flex items-center gap-1 cursor-pointer"
                        >
                            <span>💰</span>
                            <span>Kirim: pupuk organik 2 karung 150rb</span>
                        </button>
                        <button 
                            type="button"
                            wire:click="sendPreset('2 panen 1.850 kg gabah kering')"
                            class="px-2.5 py-1.5 rounded-lg bg-white border border-stone-200 hover:border-[#075E54] hover:bg-emerald-50 text-stone-800 text-[11px] font-bold shadow-2xs transition-all flex items-center gap-1 cursor-pointer"
                        >
                            <span>🌾</span>
                            <span>Kirim: 2 panen 1.850 kg gabah kering</span>
                        </button>
                        <button 
                            type="button"
                            wire:click="sendVoiceNotePreset"
                            class="px-2.5 py-1.5 rounded-lg bg-emerald-700 text-white hover:bg-emerald-800 text-[11px] font-bold shadow-2xs transition-all flex items-center gap-1 cursor-pointer"
                        >
                            <span>🎙️</span>
                            <span>Simulasi Voice Note Panen</span>
                        </button>
                    </div>
                </div>

                <!-- PHONE FRAME WRAPPER -->
                <div class="w-full max-w-[420px] bg-stone-900 rounded-[44px] p-3 shadow-2xl border-4 border-stone-800 relative">
                    
                    <!-- Dynamic Island / Speaker notch -->
                    <div class="absolute top-5 left-1/2 -translate-x-1/2 w-28 h-5 bg-black rounded-full z-40 flex items-center justify-end px-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-stone-800 border border-stone-700"></div>
                    </div>

                    <!-- Inner Phone Screen -->
                    <div class="bg-[#EFEAE2] rounded-[36px] overflow-hidden flex flex-col h-[700px] relative shadow-inner">
                        
                        <!-- 1. WHATSAPP HEADER (#075E54) -->
                        <div class="bg-[#075E54] text-white pt-7 pb-2.5 px-3 flex items-center justify-between shadow-md relative z-20">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('storefront.index') }}" class="text-white hover:opacity-80 p-0.5">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                                    </svg>
                                </a>
                                
                                <!-- Avatar Petani -->
                                <div class="relative">
                                    <img 
                                        src="{{ $farmer->foto_url ?? 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&q=80&w=400' }}" 
                                        alt="{{ $farmer->nama }}"
                                        class="w-9 h-9 rounded-full object-cover border border-white/30 shadow-2xs"
                                    />
                                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full bg-emerald-400 border border-[#075E54]"></span>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <div class="font-bold text-[13px] leading-tight truncate text-white">
                                        Asisten Tani Amanah
                                    </div>
                                    <div class="text-[10px] text-emerald-100/90 leading-tight truncate">
                                        Koperasi Tani Panosogan • WhatsApp
                                    </div>
                                </div>
                            </div>

                            <!-- Header Action Icons -->
                            <div class="flex items-center gap-3 text-emerald-100">
                                <button type="button" class="hover:text-white" title="Panggilan Video">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/>
                                    </svg>
                                </button>
                                <button type="button" class="hover:text-white" title="Panggilan Suara">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                                    </svg>
                                </button>
                                <button type="button" class="hover:text-white" title="Menu Opsi">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- 2. WHATSAPP CHAT WALLPAPER & MESSAGES AREA (#EFEAE2) -->
                        <div 
                            id="chatContainer"
                            class="flex-1 overflow-y-auto p-3 space-y-3 bg-[#EFEAE2] relative scroll-smooth"
                            style="background-image: radial-gradient(#d6cfc3 0.75px, transparent 0.75px); background-size: 16px 16px;"
                        >
                            
                            <!-- Date Badge -->
                            <div class="flex justify-center my-1">
                                <span class="bg-white/85 text-stone-600 text-[10px] font-bold px-3 py-0.5 rounded-lg shadow-2xs border border-stone-200/50 uppercase tracking-wider">
                                    Hari Ini
                                </span>
                            </div>

                            <!-- End-to-end Encryption Banner -->
                            <div class="flex justify-center mb-2">
                                <div class="bg-[#FFF3C4]/90 text-stone-700 text-[10px] px-3 py-1.5 rounded-lg shadow-2xs border border-amber-200/60 max-w-[90%] text-center leading-tight">
                                    🔒 Pesan dan data tersinkronisasi otomatis dengan Buku Kas Koperasi & Dasbor Desa Panosogan.
                                </div>
                            </div>

                            <!-- Message Bubbles Loop -->
                            @foreach($messages as $msg)
                                @if($msg['sender'] === 'farmer')
                                    <!-- INBOUND BUBBLE (FARMER / PAK DARMA) - HIJAU MUDA #DCF8C6 -->
                                    <div class="flex justify-end mb-2">
                                        <div class="max-w-[84%] bg-[#DCF8C6] text-stone-900 rounded-2xl rounded-tr-xs px-3.5 py-2 shadow-2xs text-[13px] leading-relaxed relative">
                                            
                                            @if($msg['type'] === 'voice_note')
                                                <!-- Voice Note Waveform Player UI -->
                                                <div class="flex items-center gap-2.5 pb-1 pt-0.5">
                                                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-2xs">
                                                        <svg class="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M8 5v14l11-7z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1 space-y-1">
                                                        <!-- Waveform bars -->
                                                        <div class="flex items-center gap-0.5 h-4">
                                                            <span class="w-0.5 h-3 bg-emerald-700 rounded-full animate-pulse"></span>
                                                            <span class="w-0.5 h-4 bg-emerald-700 rounded-full"></span>
                                                            <span class="w-0.5 h-2 bg-emerald-700 rounded-full"></span>
                                                            <span class="w-0.5 h-4 bg-emerald-700 rounded-full"></span>
                                                            <span class="w-0.5 h-3 bg-emerald-700 rounded-full"></span>
                                                            <span class="w-0.5 h-1.5 bg-emerald-600 rounded-full"></span>
                                                            <span class="w-0.5 h-4 bg-emerald-600 rounded-full"></span>
                                                            <span class="w-0.5 h-3 bg-emerald-600 rounded-full"></span>
                                                            <span class="w-0.5 h-2 bg-emerald-600 rounded-full"></span>
                                                            <span class="w-0.5 h-3.5 bg-emerald-600 rounded-full"></span>
                                                            <span class="w-0.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                                            <span class="w-0.5 h-2 bg-emerald-500 rounded-full"></span>
                                                        </div>
                                                        <div class="flex justify-between text-[9px] text-stone-500 font-semibold">
                                                            <span>0:14</span>
                                                            <span>🎙️ Pesan Suara</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-[11px] text-stone-600 italic border-t border-emerald-200/60 pt-1 mt-1">
                                                    "{{ $msg['text'] }}"
                                                </div>
                                            @else
                                                <div class="whitespace-pre-line">{!! nl2br(e($msg['text'])) !!}</div>
                                            @endif

                                            <div class="flex items-center justify-end gap-1 mt-0.5 text-[10px] text-stone-500">
                                                <span>{{ $msg['time'] }}</span>
                                                <!-- Double Blue Checkmark -->
                                                <svg class="w-3.5 h-3.5 text-[#34B7F1]" viewBox="0 0 16 15" fill="none">
                                                    <path d="M15.01 3.316l-7.79 7.79-4.22-4.22.71-.71 3.51 3.51 7.08-7.08.71.71zm-4.24 0l-7.79 7.79-1.98-1.98.71-.71 1.27 1.27 7.08-7.08.71.71z" fill="currentColor"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- OUTBOUND BUBBLE (BOT / ASISTEN TANI) - PUTIH #FFFFFF -->
                                    <div class="flex justify-start mb-2">
                                        <div class="max-w-[88%] bg-white text-stone-900 rounded-2xl rounded-tl-xs px-3.5 py-2.5 shadow-xs text-[13px] leading-relaxed relative border border-stone-200/60">
                                            
                                            <!-- Message Text Content -->
                                            <div class="whitespace-pre-line text-stone-800 space-y-1">
                                                @php
                                                    $formattedText = e($msg['text']);
                                                    // Convert *bold* to <strong>
                                                    $formattedText = preg_replace('/\*(.*?)\*/', '<strong>$1</strong>', $formattedText);
                                                    // Convert _italic_ to <em>
                                                    $formattedText = preg_replace('/\_(.*?)\_/', '<em>$1</em>', $formattedText);
                                                @endphp
                                                {!! nl2br($formattedText) !!}
                                            </div>

                                            <!-- Timestamp -->
                                            <div class="flex items-center justify-end gap-1 mt-1 text-[10px] text-stone-400">
                                                <span>{{ $msg['time'] }}</span>
                                            </div>

                                            <!-- INTERACTIVE ACTION BUTTONS -->
                                            @if(!empty($msg['buttons']))
                                                <div class="mt-3 pt-2 border-t border-stone-100 space-y-1.5">
                                                    @foreach($msg['buttons'] as $btn)
                                                        <button 
                                                            type="button"
                                                            wire:click="clickButton('{{ $btn['id'] }}', '{{ $btn['title'] }}')"
                                                            class="w-full py-2 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-[#075E54] font-bold text-xs flex items-center justify-center gap-1.5 transition-all shadow-2xs active:scale-98 cursor-pointer"
                                                        >
                                                            @if(str_contains(strtolower($btn['title']), 'salurkan') || str_contains(strtolower($btn['title']), 'ya'))
                                                                <span>🤝</span>
                                                            @else
                                                                <span>⏳</span>
                                                            @endif
                                                            <span>{{ $btn['title'] }}</span>
                                                        </button>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>

                        <!-- 3. INPUT BAR (BOTTOM OF PHONE) -->
                        <div class="bg-[#F0F2F5] px-2.5 py-2 border-t border-stone-200 flex items-center gap-2 relative z-20">
                            <!-- Emoji Icon -->
                            <button type="button" class="text-stone-500 hover:text-stone-700 p-1">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>

                            <!-- Attachment Icon -->
                            <button type="button" class="text-stone-500 hover:text-stone-700 p-1">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.37l-8.5 8.5a1.5 1.5 0 01-2.122-2.122l7.78-7.78" />
                                </svg>
                            </button>

                            <!-- Text Input Form -->
                            <form wire:submit.prevent="sendMessage" class="flex-1 flex items-center">
                                <input 
                                    type="text" 
                                    wire:model="messageText"
                                    placeholder="Ketik pesan atau angka menu..."
                                    class="w-full bg-white rounded-full px-4 py-2 text-xs text-stone-900 border border-stone-200 focus:outline-none focus:ring-1 focus:ring-[#075E54] focus:border-[#075E54] shadow-2xs"
                                />
                            </form>

                            <!-- Send / Microphone Button -->
                            @if(trim($messageText) !== '')
                                <button 
                                    type="button" 
                                    wire:click="sendMessage"
                                    class="w-8 h-8 rounded-full bg-[#075E54] text-white flex items-center justify-center hover:bg-[#128C7E] transition-transform active:scale-95 shadow-xs cursor-pointer"
                                    title="Kirim pesan"
                                >
                                    <svg class="w-4 h-4 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg>
                                </button>
                            @else
                                <button 
                                    type="button" 
                                    wire:click="sendVoiceNotePreset"
                                    class="w-8 h-8 rounded-full bg-[#075E54] text-white flex items-center justify-center hover:bg-[#128C7E] transition-transform active:scale-95 shadow-xs cursor-pointer"
                                    title="Kirim Voice Note Simulasi"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z" />
                                    </svg>
                                </button>
                            @endif
                        </div>

                    </div>
                </div>

            </div>

            <!-- COMPANION LIVE TELEMETRY COLUMN (lg:col-span-5) -->
            <div class="lg:col-span-5 space-y-5">
                
                <!-- Card 1: Identitas Petani & Sawah -->
                <div class="bg-white rounded-2xl border border-stone-200/80 p-5 shadow-xs space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-stone-100">
                        <div class="flex items-center gap-3">
                            <img 
                                src="{{ $farmer->foto_url ?? 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&q=80&w=400' }}" 
                                alt="{{ $farmer->nama }}"
                                class="w-12 h-12 rounded-xl object-cover border border-stone-200 shadow-2xs"
                            />
                            <div>
                                <h3 class="font-bold text-base text-stone-900 leading-tight">
                                    {{ $farmer->nama }}
                                </h3>
                                <p class="text-xs text-stone-500 font-medium">
                                    {{ $farmer->blok_lahan }} • {{ $farmer->luas_lahan_ha }} ha sawah
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            Petani Anggota
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="bg-stone-50 p-2.5 rounded-xl border border-stone-100">
                            <span class="text-[10px] text-stone-500 block uppercase font-bold tracking-wider">Nomor WhatsApp</span>
                            <span class="font-bold text-stone-900 mt-0.5 block">{{ $farmer->nomor_wa }}</span>
                        </div>
                        <div class="bg-stone-50 p-2.5 rounded-xl border border-stone-100">
                            <span class="text-[10px] text-stone-500 block uppercase font-bold tracking-wider">Tipe Irigasi</span>
                            <span class="font-bold text-emerald-800 mt-0.5 block">
                                {{ $farmer->tipe_irigasi === \App\Enums\IrrigationType::Paid ? 'Irigasi Berbayar (5%)' : 'Tadah Hujan (10%)' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Live Database Impact Telemetry -->
                <div class="bg-white rounded-2xl border border-stone-200/80 p-5 shadow-xs space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-stone-100">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></div>
                            <h4 class="font-bold text-sm text-stone-900">
                                Sinkronisasi Real-Time Database
                            </h4>
                        </div>
                        <span class="text-[10px] font-extrabold text-[#1E3F2B] bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                            {{ $season->kode_musim }}
                        </span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <!-- Status Akad Salam -->
                        <div class="flex items-center justify-between p-3 rounded-xl bg-stone-50 border border-stone-100">
                            <div>
                                <span class="font-bold text-stone-800 block">Status Akad Salam</span>
                                <span class="text-[11px] text-stone-500">Kewajiban serah gabah ke koperasi</span>
                            </div>
                            <div>
                                @php
                                    $isFulfilled = ($salamContract?->status === \App\Enums\SalamStatus::Fulfilled);
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold {{ $isFulfilled ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                                    @if($isFulfilled)
                                        <span>✓</span>
                                        <span>Sudah diserahkan</span>
                                    @else
                                        <span>⏳</span>
                                        <span>Menunggu panen</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Cadangan Leuit Desa -->
                        <div class="flex items-center justify-between p-3 rounded-xl bg-stone-50 border border-stone-100">
                            <div>
                                <span class="font-bold text-stone-800 block">Cadangan Leuit Desa (2%)</span>
                                <span class="text-[11px] text-stone-500">Lumbung ketahanan pangan desa</span>
                            </div>
                            <div class="text-right">
                                <span class="font-extrabold text-sm text-stone-900">
                                    {{ number_format((float)($latestHarvest?->leuit_kg ?? 35), 1, ',', '.') }} kg
                                </span>
                                <span class="block text-[10px] text-emerald-700 font-semibold">Tersimpan di leuit</span>
                            </div>
                        </div>

                        <!-- Zakat Panen Tercatat -->
                        <div class="flex items-center justify-between p-3 rounded-xl bg-stone-50 border border-stone-100">
                            <div>
                                <span class="font-bold text-stone-800 block">Zakat Panen Pertanian</span>
                                <span class="text-[11px] text-stone-500">Penyaluran mustahik via UPZ</span>
                            </div>
                            <div class="text-right">
                                <span class="font-extrabold text-sm text-stone-900">
                                    {{ number_format((float)($latestHarvest?->zakat_kg ?? 92.5), 1, ',', '.') }} kg
                                </span>
                                @php
                                    $zakatSalur = $latestHarvest?->zakat_disalurkan ?? 'UPZ Masjid Jami Panosogan';
                                    $isSalur = !in_array($zakatSalur, ['Menunggu konfirmasi', 'Belum disalurkan', '']);
                                @endphp
                                <span class="block text-[10px] {{ $isSalur ? 'text-emerald-700 font-bold' : 'text-amber-700 font-semibold' }}">
                                    {{ $isSalur ? 'Tersalurkan ✓' : 'Menunggu Konfirmasi' }}
                                </span>
                            </div>
                        </div>

                        <!-- Total Biaya Usahatani -->
                        <div class="flex items-center justify-between p-3 rounded-xl bg-stone-50 border border-stone-100">
                            <div>
                                <span class="font-bold text-stone-800 block">Akumulasi Biaya Tercatat</span>
                                <span class="text-[11px] text-stone-500">Buku kas musim tanam berjalan</span>
                            </div>
                            <div class="text-right">
                                <span class="font-extrabold text-sm text-stone-900">
                                    Rp {{ number_format($totalExpenses, 0, ',', '.') }}
                                </span>
                                <span class="block text-[10px] text-stone-500">via WhatsApp</span>
                            </div>
                        </div>
                    </div>

                    <!-- Direct Navigation CTAs -->
                    <div class="pt-2 border-t border-stone-100 flex flex-col sm:flex-row gap-2">
                        <a 
                            href="{{ route('rapor.show', 'pak-darma-mt1-2027') }}" 
                            target="_blank"
                            class="flex-1 py-2 px-3 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-800 font-bold text-xs text-center transition-colors"
                        >
                            📋 Lihat Rapor Petani
                        </a>
                        <a 
                            href="/admin" 
                            target="_blank"
                            class="flex-1 py-2 px-3 rounded-xl bg-[#1E3F2B] hover:bg-[#2C543B] text-white font-bold text-xs text-center transition-colors"
                        >
                            ⚙️ Buka Dasbor Admin
                        </a>
                    </div>
                </div>

                <!-- Card 3: Info Petunjuk Demo Investor / Juri -->
                <div class="bg-emerald-950 text-emerald-100 rounded-2xl p-5 shadow-xs space-y-3">
                    <div class="flex items-center gap-2 text-amber-300 font-bold text-xs">
                        <span>💡</span>
                        <span>Skenario Uji Coba Cepat (Pitch / Demo)</span>
                    </div>
                    <p class="text-xs text-emerald-200/90 leading-relaxed">
                        1. Klik <strong>"Kirim: pupuk organik 2 karung 150rb"</strong> untuk melihat bot mem-parsing nominal dan menjumlahkan buku kas biaya usahatani secara instan.<br><br>
                        2. Klik <strong>"Simulasi Voice Note Panen"</strong> atau <strong>"Kirim: 2 panen 1.850 kg gabah kering"</strong> untuk melihat kalkulasi zakat (5% paid), potongan cadangan Leuit Desa (2%), dan penutupan status Akad Salam menjadi <em>Fulfilled</em>.<br><br>
                        3. Klik tombol interaktif <strong>"Ya, salurkan"</strong> pada balasan bot untuk mengonfirmasi zakat diserahkan ke UPZ Masjid Desa.
                    </p>
                </div>

            </div>

        </div>

    </div>
</div>
