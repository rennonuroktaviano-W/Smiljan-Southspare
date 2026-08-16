<section class="bg-paper" id="komunitas">
    <div class="wrap py-28 lg:py-44">
        <div class="flex items-baseline justify-between font-mono text-[0.62rem] uppercase tracking-[0.26em]">
            <span class="text-olive" data-reveal>{{ config('site.community.index') }} / {{ config('site.community.label') }}</span>
            <span class="hidden sm:inline" data-reveal>{{ config('site.community.en') }}</span>
        </div>

        <h2 class="mt-14 max-w-4xl font-display text-[clamp(2.5rem,8vw,7rem)] leading-[0.92] tracking-[-0.01em] lg:mt-20">
            @foreach (config('site.community.title') as $index => $line)
                <span class="reveal block" data-reveal style="--d: {{ $index * 0.1 }}s">{{ $line }}</span>
            @endforeach
        </h2>
        <p class="mt-8 max-w-md text-[1.05rem] leading-relaxed text-ink/75" data-reveal>{{ config('site.community.copy') }}</p>

        <div class="mt-16 border-t hairline lg:mt-24">
            @foreach (config('site.community.events') as $event)
                <article class="group grid gap-2 border-b hairline py-8 transition-colors duration-500 hover:bg-bg/50 lg:grid-cols-12 lg:items-baseline lg:gap-6" data-reveal>
                    <span class="font-mono text-[0.68rem] uppercase tracking-[0.22em] text-olive lg:col-span-2">{{ $event['n'] }}</span>
                    <h3 class="font-display text-[1.7rem] leading-none lg:col-span-4 lg:text-[2.1rem] transition-transform duration-500 group-hover:translate-x-2">
                        {{ $event['name'] }}
                    </h3>
                    <p class="max-w-xs text-[0.9rem] leading-relaxed text-ink/65 lg:col-span-5">{{ $event['desc'] }}</p>
                    <span class="font-mono text-[0.6rem] uppercase tracking-[0.22em] text-wood lg:col-span-1 lg:text-right">{{ $event['status'] }}</span>
                </article>
            @endforeach
        </div>

        <p class="mt-8 font-mono text-[0.6rem] uppercase tracking-[0.22em] text-olive" data-reveal>
            AGENDA MENYUSUL — DIPERBARUI DARI RUANG
        </p>
    </div>
</section>
