<section id="jurnal">
    <div class="wrap py-28 lg:py-44">
        <div class="flex items-baseline justify-between font-mono text-[0.62rem] uppercase tracking-[0.26em]">
            <span class="text-olive" data-reveal>{{ siteSetting('journal', 'index') }} / {{ siteSetting('journal', 'label') }}</span>
            <span class="hidden sm:inline" data-reveal>{{ siteSetting('journal', 'en') }}</span>
        </div>

        <div class="mt-14 grid gap-16 lg:mt-20 lg:grid-cols-12 lg:gap-x-10">
            @foreach ($articles as $index => $article)
                @php
                    $featured = $index === 0;
                    $wide = $featured ? 'lg:col-span-7' : 'lg:col-span-5';
                    $offset = $index === 1 ? 'lg:mt-32' : '';
                    $titleSize = $featured ? 'text-[clamp(2rem,4.5vw,3.8rem)]' : 'text-[clamp(1.5rem,3vw,2.4rem)]';
                @endphp
                <article class="{{ $wide }} {{ $offset }}" data-reveal>
                    <a href="{{ route('journal.show', $article['slug']) }}" class="group block" aria-label="{{ $article['title'] }}">
                        <figure class="img-frame aspect-[4/3]">
                            <img src="{{ asset($article['src']) }}" alt="{{ $article['alt'] }}" width="1000" height="750" loading="lazy" decoding="async">
                        </figure>
                        <figcaption class="mt-4 flex items-baseline justify-between font-mono text-[0.6rem] uppercase tracking-[0.22em] text-olive">
                            <span>{{ $article['category'] }}</span>
                            <span>{{ $article['meta'] }}</span>
                        </figcaption>
                        <h3 class="mt-3 font-display {{ $titleSize }} leading-[1.02] transition-colors duration-500 group-hover:text-wood">
                            {{ $article['title'] }}
                        </h3>
                        <p class="mt-3 max-w-md text-[0.92rem] leading-relaxed text-ink/70">
                            {{ $article['excerpt'] }}
                            <span class="inline-block translate-y-[2px] font-mono text-[0.6rem] uppercase tracking-[0.2em] text-wood transition-transform duration-500 group-hover:translate-x-2">→</span>
                        </p>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
