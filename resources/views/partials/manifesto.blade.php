<section class="bg-paper" id="filosofi">
    <div class="wrap py-28 lg:py-44">
        <div class="flex items-baseline justify-between font-mono text-[0.62rem] uppercase tracking-[0.26em]">
            <span class="text-olive" data-reveal>{{ config('site.manifesto.index') }} / {{ config('site.manifesto.label') }}</span>
            <span class="hidden sm:inline" data-reveal>{{ config('site.manifesto.en') }}</span>
        </div>

        <h2 class="mt-14 max-w-5xl font-display text-[clamp(2.5rem,8vw,7rem)] leading-[0.95] tracking-[-0.01em] lg:mt-20">
            @foreach (config('site.manifesto.title') as $index => $line)
                <span class="reveal block" data-reveal style="--d: {{ $index * 0.1 }}s">{{ $line }}</span>
            @endforeach
        </h2>

        <div class="mt-12 grid gap-8 lg:mt-16 lg:grid-cols-12">
            <p class="max-w-md text-[1.05rem] leading-relaxed text-ink/80 lg:col-span-5 lg:col-start-7" data-reveal>
                {{ config('site.manifesto.copy') }}
            </p>
        </div>

        <div class="relative mt-20 overflow-hidden lg:mt-32" data-reveal>
            <span class="outline-text block whitespace-nowrap font-display text-[clamp(3.5rem,17vw,16rem)] leading-[0.85] parallax-text" data-text-shift aria-hidden="true">
                {{ config('site.manifesto.accent.id') }}
            </span>
            <span class="absolute bottom-6 right-0 font-mono text-[0.65rem] uppercase tracking-[0.28em] text-wood">
                {{ config('site.manifesto.accent.en') }}
            </span>
        </div>
    </div>
</section>
