<section id="ruang">
    <div class="wrap py-28 lg:py-44">
        <div class="flex items-baseline justify-between font-mono text-[0.62rem] uppercase tracking-[0.26em]">
            <span class="text-olive" data-reveal>{{ siteSetting('space', 'index') }} / {{ siteSetting('space', 'label') }}</span>
            <span class="hidden sm:inline" data-reveal>{{ siteSetting('space', 'en') }}</span>
        </div>

        <div class="mt-12 grid gap-8 lg:mt-16 lg:grid-cols-12 lg:items-start">
            <div class="lg:col-span-8">
                <h2 class="font-display text-[clamp(2.4rem,7vw,6.2rem)] leading-[0.92] tracking-[-0.01em]">
                    @foreach (siteSetting('space.title') as $index => $line)
                        <span class="reveal block" data-reveal style="--d: {{ $index * 0.1 }}s">{{ $line }}</span>
                    @endforeach
                </h2>
                <p class="mt-8 max-w-md text-[1rem] leading-relaxed text-ink/75" data-reveal>{{ siteSetting('space', 'copy') }}</p>
            </div>
            <div class="lg:col-span-4 lg:mt-2">
                <p class="max-w-xs text-[0.95rem] leading-relaxed text-olive" data-reveal>
                    {{ siteSetting('space.items.0.caption') }} — {{ siteSetting('space.items.1.caption') }} — {{ siteSetting('space.items.2.caption') }} — {{ siteSetting('space.items.3.caption') }}
                </p>
            </div>
        </div>

        @php($items = siteSetting('space.items'))
        <div class="mt-16 grid gap-x-6 gap-y-14 lg:mt-24 lg:grid-cols-12">
            <figure class="lg:col-span-8" data-reveal data-tilt>
                <div class="img-frame aspect-[4/3]">
                    <img src="{{ asset($items[0]['src']) }}" alt="{{ $items[0]['alt'] }}" width="1200" height="900" loading="lazy" decoding="async">
                </div>
                <figcaption class="mt-3 flex items-baseline justify-between font-mono text-[0.6rem] uppercase tracking-[0.22em]">
                    <span class="text-olive">{{ $items[0]['n'] }}</span>
                    <span class="flex gap-4">
                        <span>{{ $items[0]['caption'] }}</span>
                        <span class="text-wood">/ {{ $items[0]['en'] }}</span>
                    </span>
                </figcaption>
            </figure>

            <figure class="lg:col-span-4 lg:mt-28" data-reveal data-tilt>
                <div class="img-frame aspect-[3/4]">
                    <img src="{{ asset($items[1]['src']) }}" alt="{{ $items[1]['alt'] }}" width="800" height="1067" loading="lazy" decoding="async">
                </div>
                <figcaption class="mt-3 flex items-baseline justify-between font-mono text-[0.6rem] uppercase tracking-[0.22em]">
                    <span class="text-olive">{{ $items[1]['n'] }}</span>
                    <span class="flex gap-4">
                        <span>{{ $items[1]['caption'] }}</span>
                        <span class="text-wood">/ {{ $items[1]['en'] }}</span>
                    </span>
                </figcaption>
            </figure>

            <figure class="lg:col-span-5 lg:-mt-24" data-reveal data-tilt>
                <div class="img-frame aspect-[4/3]">
                    <img src="{{ asset($items[2]['src']) }}" alt="{{ $items[2]['alt'] }}" width="800" height="600" loading="lazy" decoding="async">
                </div>
                <figcaption class="mt-3 flex items-baseline justify-between font-mono text-[0.6rem] uppercase tracking-[0.22em]">
                    <span class="text-olive">{{ $items[2]['n'] }}</span>
                    <span class="flex gap-4">
                        <span>{{ $items[2]['caption'] }}</span>
                        <span class="text-wood">/ {{ $items[2]['en'] }}</span>
                    </span>
                </figcaption>
            </figure>

            <figure class="lg:col-span-7 lg:-mt-10" data-reveal data-tilt>
                <div class="img-frame aspect-[16/9]">
                    <img src="{{ asset($items[3]['src']) }}" alt="{{ $items[3]['alt'] }}" width="1200" height="675" loading="lazy" decoding="async">
                </div>
                <figcaption class="mt-3 flex items-baseline justify-between font-mono text-[0.6rem] uppercase tracking-[0.22em]">
                    <span class="text-olive">{{ $items[3]['n'] }}</span>
                    <span class="flex gap-4">
                        <span>{{ $items[3]['caption'] }}</span>
                        <span class="text-wood">/ {{ $items[3]['en'] }}</span>
                    </span>
                </figcaption>
            </figure>
        </div>
    </div>
</section>
