<section class="flex min-h-[100svh] items-center overflow-hidden bg-dark text-paper relative">
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22n%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.85%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23n)%22/%3E%3C/svg%3E'); background-size: 200px;" aria-hidden="true"></div>
    <div class="wrap w-full py-32 text-center relative z-10">
        <p class="font-mono text-[0.6rem] uppercase tracking-[0.28em] text-paper/50" data-reveal>
            {{ config('site.quote.en') }}
        </p>

        <h2 class="mt-12 font-display text-[clamp(2.2rem,8vw,7.5rem)] leading-[0.95] tracking-[-0.01em]">
            @foreach (config('site.quote.lines') as $index => $line)
                <span class="reveal block {{ $line['italic'] ? 'italic text-wood' : '' }}" data-reveal style="--d: {{ 0.2 + $index * 0.18 }}s">
                    {{ $line['text'] }}
                </span>
            @endforeach
        </h2>

        <p class="mt-12 font-mono text-[0.62rem] uppercase tracking-[0.26em] text-paper/45" data-reveal style="--d: 0.8s">
            {{ config('site.brand.coords') }}
        </p>
    </div>
</section>
