<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <span style="width: 0.625rem; height: 0.625rem; display: inline-block;" class="rounded-full bg-[#15803D] shrink-0"></span>
                <span class="font-extrabold text-base tracking-tight text-stone-900 dark:text-stone-100">
                    Rapor Amanah Desa
                </span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-[#15803D] dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                    MT-1 2027
                </span>
            </div>
        </x-slot>

        <x-slot name="description">
            <span class="text-xs text-stone-500 dark:text-stone-400">
                Transparansi pemenuhan komitmen ekologis dan keadilan budidaya bersama Koperasi Tani Panosogan
            </span>
        </x-slot>

        <div class="space-y-6">

            <!-- Banner Kutipan Sunda -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-amber-50 via-amber-100/40 to-amber-50 dark:from-amber-950/30 dark:via-amber-900/20 dark:to-amber-950/30 border border-amber-200/80 dark:border-amber-800/60 p-5 text-center shadow-xs">
                <div class="inline-block text-[11px] font-extrabold uppercase tracking-widest text-amber-800 dark:text-amber-400 mb-1">
                    Piwuruk Kolot • Panosogan
                </div>
                <blockquote class="text-lg sm:text-xl font-black text-amber-950 dark:text-amber-200 italic tracking-tight">
                    {{ $quote }}
                </blockquote>
                <p class="text-xs text-amber-900/80 dark:text-amber-300/80 mt-1.5 max-w-xl mx-auto leading-relaxed">
                    {{ $quoteMeaning }}
                </p>
            </div>

            <!-- Progress Bars Agregat 3 Komitmen Utama -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- 1. Jerami tidak dibakar -->
                <div class="bg-stone-50 dark:bg-stone-900/50 rounded-xl p-4 border border-stone-200/80 dark:border-stone-800">
                    <div class="flex items-center justify-between text-xs mb-2">
                        <span class="font-bold text-stone-700 dark:text-stone-300">
                            Jerami tidak dibakar
                        </span>
                        <span class="font-extrabold text-[#15803D] dark:text-emerald-400 tabular-nums">
                            {{ $jeramiCount }} dari {{ $totalFarmers }}
                        </span>
                    </div>
                    <div style="height: 0.625rem;" class="w-full bg-stone-200 dark:bg-stone-800 rounded-full overflow-hidden">
                        <div class="bg-[#15803D] rounded-full transition-all duration-500" style="height: 0.625rem; width: {{ $jeramiPercent }}%;"></div>
                    </div>
                    <div class="flex items-center justify-between mt-2 text-[11px] text-stone-500 dark:text-stone-400">
                        <span>Pencapaian: {{ $jeramiPercent }}%</span>
                        <span class="text-emerald-700 dark:text-emerald-400 font-semibold">Bebas Polusi Asap</span>
                    </div>
                </div>

                <!-- 2. Pupuk sesuai dosis -->
                <div class="bg-stone-50 dark:bg-stone-900/50 rounded-xl p-4 border border-stone-200/80 dark:border-stone-800">
                    <div class="flex items-center justify-between text-xs mb-2">
                        <span class="font-bold text-stone-700 dark:text-stone-300">
                            Pupuk sesuai dosis
                        </span>
                        <span class="font-extrabold text-[#15803D] dark:text-emerald-400 tabular-nums">
                            {{ $pupukCount }} dari {{ $totalFarmers }}
                        </span>
                    </div>
                    <div style="height: 0.625rem;" class="w-full bg-stone-200 dark:bg-stone-800 rounded-full overflow-hidden">
                        <div class="bg-[#15803D] rounded-full transition-all duration-500" style="height: 0.625rem; width: {{ $pupukPercent }}%;"></div>
                    </div>
                    <div class="flex items-center justify-between mt-2 text-[11px] text-stone-500 dark:text-stone-400">
                        <span>Pencapaian: {{ $pupukPercent }}%</span>
                        <span class="text-emerald-700 dark:text-emerald-400 font-semibold">Organik & Berimbang</span>
                    </div>
                </div>

                <!-- 3. Lepas dari ijon -->
                <div class="bg-stone-50 dark:bg-stone-900/50 rounded-xl p-4 border border-stone-200/80 dark:border-stone-800">
                    <div class="flex items-center justify-between text-xs mb-2">
                        <span class="font-bold text-stone-700 dark:text-stone-300">
                            Lepas dari ijon
                        </span>
                        <span class="font-extrabold text-[#15803D] dark:text-emerald-400 tabular-nums">
                            {{ $bebasIjonCount }} dari {{ $totalFarmers }}
                        </span>
                    </div>
                    <div style="height: 0.625rem;" class="w-full bg-stone-200 dark:bg-stone-800 rounded-full overflow-hidden">
                        <div class="bg-[#15803D] rounded-full transition-all duration-500" style="height: 0.625rem; width: {{ $bebasIjonPercent }}%;"></div>
                    </div>
                    <div class="flex items-center justify-between mt-2 text-[11px] text-stone-500 dark:text-stone-400">
                        <span>Pencapaian: {{ $bebasIjonPercent }}%</span>
                        <span class="text-emerald-700 dark:text-emerald-400 font-semibold">Mandiri Modal Salam</span>
                    </div>
                </div>

            </div>

            <!-- Ringkasan Zakat & Pohon Ditanam -->
            <div class="rounded-xl bg-stone-100/70 dark:bg-stone-900/80 p-4 border border-stone-200/90 dark:border-stone-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                
                <!-- Zakat Tercatat -->
                <div class="flex items-center gap-3">
                    <div style="width: 2.75rem; height: 2.75rem; min-width: 2.75rem; min-height: 2.75rem;" class="rounded-xl bg-emerald-100 dark:bg-emerald-950/70 text-[#15803D] dark:text-emerald-400 flex items-center justify-center shrink-0 border border-emerald-200 dark:border-emerald-800">
                        <x-filament::icon
                            :icon="\Filament\Support\Icons\Heroicon::OutlinedGift"
                            class="fi-size-md"
                            style="width: 1.35rem; height: 1.35rem; display: block;"
                        />
                    </div>
                    <div>
                        <div class="text-[11px] uppercase tracking-wider font-extrabold text-stone-500 dark:text-stone-400">
                            Zakat Tercatat
                        </div>
                        <div class="text-sm font-black text-stone-900 dark:text-stone-100">
                            {{ $zakatSummary }}
                        </div>
                        <div class="text-[11px] text-stone-500 dark:text-stone-400">
                            Tersalurkan ke UPZ Masjid Jami Panosogan
                        </div>
                    </div>
                </div>

                <!-- Divider on desktop -->
                <div style="height: 2.5rem; width: 1px;" class="hidden sm:block bg-stone-200 dark:bg-stone-800"></div>

                <!-- Pohon Ditanam -->
                <div class="flex items-center gap-3">
                    <div style="width: 2.75rem; height: 2.75rem; min-width: 2.75rem; min-height: 2.75rem;" class="rounded-xl bg-emerald-100 dark:bg-emerald-950/70 text-[#15803D] dark:text-emerald-400 flex items-center justify-center shrink-0 border border-emerald-200 dark:border-emerald-800">
                        <x-filament::icon
                            :icon="\Filament\Support\Icons\Heroicon::OutlinedSparkles"
                            class="fi-size-md"
                            style="width: 1.35rem; height: 1.35rem; display: block;"
                        />
                    </div>
                    <div>
                        <div class="text-[11px] uppercase tracking-wider font-extrabold text-stone-500 dark:text-stone-400">
                            Pohon Ditanam
                        </div>
                        <div class="text-sm font-black text-stone-900 dark:text-stone-100">
                            {{ $pohonSummary }}
                        </div>
                        <div class="text-[11px] text-stone-500 dark:text-stone-400">
                            Perindang pematang sawah & konservasi air
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
