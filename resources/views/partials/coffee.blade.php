<section class="bg-paper" id="kopi">
    <div class="wrap py-28 lg:py-44">
        <div class="flex items-baseline justify-between font-mono text-[0.62rem] uppercase tracking-[0.26em]">
            <span class="text-olive" data-reveal>{{ siteSetting('coffee', 'index') }} / {{ siteSetting('coffee', 'label') }}</span>
            <span class="hidden sm:inline" data-reveal>{{ siteSetting('coffee', 'en') }}</span>
        </div>

        <div class="mt-14 grid gap-14 lg:mt-20 lg:grid-cols-12">
            <div class="lg:col-span-7">
                <h2 class="font-display text-[clamp(2.6rem,8.5vw,7.5rem)] leading-[0.9] tracking-[-0.01em]">
                    @foreach (siteSetting('coffee.title') as $index => $line)
                        <span class="reveal block" data-reveal style="--d: {{ $index * 0.1 }}s">{{ $line }}</span>
                    @endforeach
                </h2>
                <p class="mt-8 max-w-md text-[1rem] leading-relaxed text-ink/75" data-reveal>{{ siteSetting('coffee', 'copy') }}</p>

                @foreach ($menuGroups->where('is_coffee', true) as $category)
                    <section class="mt-14 border-t pt-6 hairline" data-reveal>
                        <div class="flex items-baseline justify-between gap-4">
                            <h3 class="font-mono text-[0.75rem] uppercase tracking-[0.28em]">{{ $category['name'] }}</h3>
                            <span class="font-mono text-[0.58rem] uppercase tracking-[0.2em] text-olive">{{ $category['note'] }}</span>
                        </div>
                        <ul class="mt-3">
                            @foreach ($category['items'] as $item)
                                <li class="flex items-baseline gap-4 border-b border-ink/10 py-3.5 last:border-b-0 transition-colors duration-300 hover:bg-ink/[.02]">
                                    <span class="font-display text-[1.3rem] leading-none lg:text-[1.55rem]">{{ $item['name'] }}</span>
                                    <span class="hidden flex-1 border-b border-dotted border-ink/20 sm:block" aria-hidden="true"></span>
                                    <span class="max-w-[12rem] text-right text-[0.78rem] leading-snug text-ink/65">{{ $item['desc'] }}</span>
                                    <span class="w-16 text-right font-mono text-[0.68rem] text-olive whitespace-nowrap">
                                        {{ $item['price'] ? 'Rp ' . number_format($item['price'], 0, ',', '.') : '—' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endforeach
            </div>

            <aside class="lg:col-span-5 lg:pl-6">
                <div class="lg:sticky lg:top-28" data-reveal data-tilt>
                    <figure class="img-frame aspect-[3/4]">
                        <img src="{{ asset(siteSetting('coffee', 'image.src')) }}" alt="{{ siteSetting('coffee', 'image.alt') }}" width="800" height="1067" loading="lazy" decoding="async">
                    </figure>
                    <figcaption class="mt-3 flex justify-between font-mono text-[0.58rem] uppercase tracking-[0.22em] text-olive">
                        <span>FIG. 01 — FILTER</span>
                        <span>V60</span>
                    </figcaption>
                </div>
            </aside>
        </div>
    </div>
</section>
