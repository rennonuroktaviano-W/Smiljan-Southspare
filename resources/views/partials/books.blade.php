<section id="buku">
    <div class="wrap py-28 lg:py-44">
        <div class="flex items-baseline justify-between font-mono text-[0.62rem] uppercase tracking-[0.26em]">
            <span class="text-olive" data-reveal>{{ siteSetting('books', 'index') }} / {{ siteSetting('books', 'label') }}</span>
            <span class="hidden sm:inline" data-reveal>{{ siteSetting('books', 'en') }}</span>
        </div>

        <div class="mt-14 grid gap-12 lg:mt-20 lg:grid-cols-12 lg:items-center">
            <div class="lg:col-span-6">
                <h2 class="font-display text-[clamp(2.6rem,8.5vw,7.5rem)] leading-[0.9] tracking-[-0.01em]">
                    @foreach (siteSetting('books.title') as $index => $line)
                        <span class="reveal block" data-reveal style="--d: {{ $index * 0.12 }}s">{{ $line }}</span>
                    @endforeach
                </h2>
                <p class="mt-8 max-w-sm text-[1.05rem] leading-relaxed text-ink/80" data-reveal style="--d: 0.2s">
                    {{ siteSetting('books', 'copy') }}
                </p>
                <p class="mt-10 font-mono text-[0.62rem] uppercase tracking-[0.26em] text-wood" data-reveal style="--d: 0.3s">
                    KOLEKSI PILIHAN — TIDAK UNTUK DIBURU-BURU
                </p>
            </div>

            <div class="lg:col-span-6">
                <figure class="img-frame aspect-[4/5]" data-reveal style="--d: 0.15s" data-tilt>
                    <img src="{{ asset(siteSetting('books', 'image.src')) }}" alt="{{ siteSetting('books', 'image.alt') }}" width="800" height="1000" loading="lazy" decoding="async">
                </figure>
                <figcaption class="mt-3 flex justify-between font-mono text-[0.58rem] uppercase tracking-[0.22em] text-olive">
                    <span>FIG. 02 — SHELF</span>
                    <span>R15 / BACA</span>
                </figcaption>
            </div>
        </div>
    </div>

    <div class="marquee border-y hairline py-7">
        <div class="marquee-track font-display text-[clamp(2rem,5.5vw,4.5rem)] leading-none tracking-tight" style="--dur: 48s">
            @for ($copy = 0; $copy < 2; $copy++)
                @foreach (siteSetting('books.marquee') as $item)
                    <span class="whitespace-nowrap px-8" aria-hidden="{{ $copy === 1 ? 'true' : 'false' }}">
                        {{ $item }}<span class="mx-10 text-olive">—</span>
                    </span>
                @endforeach
            @endfor
        </div>
    </div>
</section>
