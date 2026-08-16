<section class="flex min-h-[100svh] items-center overflow-hidden bg-dark text-paper">
    <div class="wrap w-full py-32 text-center">
        <p class="font-mono text-[0.6rem] uppercase tracking-[0.28em] text-paper/50" data-reveal>
            {{ config('site.quote.en') }}
        </p>

        <h2 class="mt-12 font-display text-[clamp(2.2rem,8vw,7.5rem)] leading-[0.95] tracking-[-0.01em]">
            @foreach (config('site.quote.lines') as $index => $line)
                <span class="reveal block {{ $line['italic'] ? 'italic text-wood' : '' }}" data-reveal style="--d: {{ $index * 0.18 }}s">
                    {{ $line['text'] }}
                </span>
            @endforeach
        </h2>

        <p class="mt-12 font-mono text-[0.62rem] uppercase tracking-[0.26em] text-paper/45" data-reveal style="--d: 0.8s">
            {{ config('site.brand.coords') }}
        </p>
    </div>
</section>
