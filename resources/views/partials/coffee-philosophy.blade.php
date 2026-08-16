<section class="bg-ink text-paper">
    <div class="wrap py-28 lg:py-40">
        <div class="grid gap-12 lg:grid-cols-12 lg:items-center">
            <div class="relative order-2 lg:order-1 lg:col-span-5">
                <figure class="img-frame aspect-[3/4]">
                    <img src="{{ asset(config('site.coffee_philosophy.image.src')) }}" alt="{{ config('site.coffee_philosophy.image.alt') }}" width="800" height="1067" loading="lazy" decoding="async">
                </figure>
                <span class="vert absolute -right-4 top-0 hidden font-mono text-[0.6rem] uppercase tracking-[0.3em] text-paper/50 lg:block" data-reveal>
                    {{ config('site.coffee_philosophy.mono') }}
                </span>
            </div>

            <div class="order-1 lg:order-2 lg:col-span-6 lg:col-start-7">
                <span class="font-mono text-[0.62rem] uppercase tracking-[0.26em] text-wood" data-reveal>{{ config('site.coffee.label') }} / 02</span>
                <blockquote class="mt-10 font-display text-[clamp(2rem,5.5vw,4.6rem)] leading-[1.02]">
                    <span class="reveal block" data-reveal>“{{ config('site.coffee_philosophy.quote') }}”</span>
                </blockquote>
                <p class="mt-8 text-[0.95rem] leading-relaxed text-paper/70" data-reveal style="--d: 0.15s">
                    {{ config('site.coffee_philosophy.sub') }}
                </p>
                <span class="mt-10 inline-block font-mono text-[0.6rem] uppercase tracking-[0.26em] text-paper/40" data-reveal style="--d: 0.25s">
                    06° SOUTH / 106° EAST
                </span>
            </div>
        </div>
    </div>
</section>
