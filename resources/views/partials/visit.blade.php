<section class="bg-paper" id="kunjungi">
    <div class="wrap py-28 lg:py-44">
        <div class="grid gap-14 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <div class="flex items-baseline justify-between font-mono text-[0.62rem] uppercase tracking-[0.26em]">
                    <span class="text-olive" data-reveal>{{ siteSetting('visit', 'index') }} / {{ siteSetting('visit', 'label') }}</span>
                    <span class="hidden sm:inline" data-reveal>{{ siteSetting('visit', 'en') }}</span>
                </div>

                <h2 class="mt-12 font-display text-[clamp(2.6rem,8.5vw,7.5rem)] leading-[0.9] tracking-[-0.01em]">
                    @foreach (siteSetting('visit.title') as $index => $line)
                        <span class="reveal block" data-reveal style="--d: {{ $index * 0.12 }}s">{{ $line }}</span>
                    @endforeach
                </h2>
                <p class="mt-8 max-w-sm text-[1.02rem] leading-relaxed text-ink/75" data-reveal>{{ siteSetting('visit', 'copy') }}</p>

                <div class="mt-12 border-t pt-6 hairline" data-reveal>
                    <p class="font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">{{ siteSetting('visit', 'hours_label') }}</p>
                    <p class="mt-3 font-display text-[2.1rem] leading-none">
                        {{ siteSetting('hours', 'open') }} — {{ siteSetting('hours', 'close') }}
                    </p>
                </div>

                <address class="mt-8 not-italic" data-reveal>
                    <p class="font-display text-[1.35rem] leading-snug">{{ siteSetting('brand', 'name') }} {{ siteSetting('brand', 'sub') }}</p>
                    @foreach (siteSetting('address.lines') as $line)
                        <p class="text-[0.95rem] leading-relaxed text-ink/75">{{ $line }}</p>
                    @endforeach
                </address>

                <div class="mt-10 flex flex-col gap-6" data-reveal>
                    <a href="{{ siteSetting('address', 'maps_url') }}" target="_blank" rel="noopener" class="link-line inline-flex w-fit items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]" data-magnetic>
                        {{ siteSetting('visit', 'cta') }} <span aria-hidden="true">↗</span>
                    </a>
                    <span class="font-mono text-[0.58rem] uppercase tracking-[0.22em] text-olive">{{ siteSetting('visit', 'transport') }}</span>
                </div>
            </div>

            <div class="lg:col-span-7" data-reveal>
                <div class="relative">
                    <a href="{{ siteSetting('address', 'maps_url') }}" target="_blank" rel="noopener" class="block" data-cursor>
                        <div class="img-frame map-panel aspect-[4/3] lg:aspect-[16/10]">
                            <img src="{{ asset(siteSetting('visit', 'image.src')) }}" alt="{{ siteSetting('visit', 'image.alt') }}" width="1400" height="875" loading="lazy" decoding="async">
                            <div class="map-grid pointer-events-none absolute inset-0" aria-hidden="true"></div>
                            <span class="map-pin" aria-hidden="true"></span>
                            <span class="absolute bottom-5 left-5 font-mono text-[0.6rem] uppercase tracking-[0.24em] text-paper">
                                {{ siteSetting('brand', 'coords') }}
                            </span>
                        </div>
                    </a>
                    <figcaption class="mt-3 flex justify-between font-mono text-[0.58rem] uppercase tracking-[0.22em] text-olive">
                        <span>JAKARTA SELATAN / CILANDAK BARAT</span>
                        <span>TRANSPORTASI UMUM</span>
                    </figcaption>
                </div>
            </div>
        </div>
    </div>
</section>
