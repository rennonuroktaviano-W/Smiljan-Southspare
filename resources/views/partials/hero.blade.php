<section class="relative overflow-hidden" data-hero>
    <div class="wrap pt-28 lg:pt-36 pb-10">
        <div class="flex items-center justify-between font-mono text-[0.62rem] uppercase tracking-[0.26em] text-olive">
            <span data-reveal>{{ config('site.hero.eyebrow') }}</span>
            <span class="hidden sm:inline" data-reveal>{{ config('site.hero.mono') }}</span>
        </div>

        <div class="mt-12 grid items-start gap-12 lg:mt-20 lg:grid-cols-12 lg:gap-6">
            <div class="lg:col-span-7">
                <h1 class="font-display text-[clamp(2.75rem,13.5vw,12.5rem)] leading-[0.86] tracking-[-0.02em]">
                    @foreach (config('site.hero.lines') as $index => $line)
                        <span class="hero-line" style="--d: {{ 0.3 + $index * 0.11 }}s">{{ $line }}</span>
                    @endforeach
                </h1>

                <p class="mt-9 max-w-sm text-[1rem] leading-relaxed text-ink/75" data-reveal style="--d: 0.55s">
                    {{ config('site.hero.copy') }}
                </p>
            </div>

            <div class="lg:col-span-5 lg:pt-6" data-reveal style="--d: 0.35s" data-tilt>
                <figure class="img-frame aspect-[3/4]" data-parallax>
                    <img
                        src="{{ asset(config('site.hero.image.src')) }}"
                        alt="{{ config('site.hero.image.alt') }}"
                        width="1000"
                        height="1200"
                        fetchpriority="high"
                        decoding="async"
                    >
                </figure>
                <figcaption class="mt-3 flex justify-between font-mono text-[0.58rem] uppercase tracking-[0.22em] text-olive">
                    <span>FIG. 00 — {{ config('site.brand.area') }}</span>
                    <span class="hidden sm:inline">06°17' S / 106°48' E</span>
                </figcaption>
            </div>
        </div>

        <div class="mt-16 flex items-end justify-between border-t pt-5 hairline font-mono text-[0.62rem] uppercase tracking-[0.24em] lg:mt-24">
            <a href="#filosofi" class="link-line flex items-center gap-2" data-reveal>
                {{ config('site.hero.scroll') }}
                <span aria-hidden="true">↓</span>
            </a>
            <span class="hidden text-olive md:inline" data-reveal>OPEN DAILY / 08—22</span>
        </div>
    </div>
</section>
