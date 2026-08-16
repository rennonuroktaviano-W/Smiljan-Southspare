@extends('layouts.page')

@section('title', 'Tentang — SMILJAN SOUTHSPARE')
@section('meta-description', 'Kedai kopi sekaligus perpustakaan kecil di Cilandak Barat, Jakarta Selatan. Tempat untuk membaca, bekerja, bertemu, dan kadang tak melakukan apa-apa.')

@section('content')
    <section class="pt-32 lg:pt-44">
        <div class="wrap">
            <div class="flex items-baseline justify-between font-mono text-[0.62rem] uppercase tracking-[0.26em]">
                <span class="text-olive" data-reveal>{{ config('site.about.index') }} / {{ config('site.about.label') }}</span>
                <span class="hidden sm:inline" data-reveal>{{ config('site.about.en') }}</span>
            </div>

            <div class="mt-14 grid gap-8 lg:mt-20 lg:grid-cols-12 lg:items-end">
                <h1 class="font-display text-[clamp(2.6rem,9vw,7.5rem)] leading-[0.9] tracking-[-0.01em] lg:col-span-8">
                    @foreach (config('site.about.title') as $index => $line)
                        <span class="hero-line block whitespace-nowrap" style="--d: {{ 0.08 + $index * 0.11 }}s">{{ $line }}</span>
                    @endforeach
                </h1>
                <p class="max-w-sm text-[1.02rem] leading-relaxed text-ink/75 lg:col-span-4" data-reveal style="--d: 0.4s">
                    {{ config('site.about.copy') }}
                </p>
            </div>
        </div>
    </section>

    <section class="pb-28 lg:pb-44">
        <div class="wrap">
            <div class="mt-16 grid gap-14 border-t pt-14 hairline lg:mt-24 lg:grid-cols-12">
                <div class="lg:col-span-5">
                    <span class="font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive" data-reveal>
                        {{ config('site.about.story.label') }}
                    </span>
                    <p class="mt-8 text-[1.02rem] leading-relaxed text-ink/80" data-reveal>
                        {{ config('site.about.story.copy') }}
                    </p>

                    <ul class="mt-10 flex flex-col gap-4">
                        @foreach (config('site.about.story.points') as $point)
                            <li class="flex gap-4 border-t pt-4 hairline text-[0.8rem] leading-snug text-ink/70" data-reveal>
                                <span class="mt-1.5 h-px w-6 flex-none bg-wood" aria-hidden="true"></span>
                                {{ $point }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <figure class="lg:col-span-7" data-reveal>
                    <div class="img-frame aspect-[4/3] lg:aspect-[16/10]">
                        <img src="{{ asset(config('site.about.image.src')) }}" alt="{{ config('site.about.image.alt') }}" width="1400" height="875" loading="lazy" decoding="async">
                    </div>
                    <figcaption class="mt-3 flex justify-between font-mono text-[0.58rem] uppercase tracking-[0.22em] text-olive">
                        <span>FIG. — {{ config('site.brand.area') }}</span>
                        <span>ARSITEKTUR / CAHAYA</span>
                    </figcaption>
                </figure>
            </div>

            <div class="mt-20 grid gap-8 lg:mt-28 lg:grid-cols-12">
                @foreach (config('site.about.values') as $value)
                    <div class="border-t pt-6 hairline lg:col-span-4" data-reveal>
                        <span class="font-mono text-[0.62rem] uppercase tracking-[0.24em] text-olive">{{ $value['n'] }} / {{ $value['name'] }}</span>
                        <p class="mt-4 font-display text-[1.5rem] leading-[1.05]">{{ $value['name'] }}</p>
                        <p class="mt-3 max-w-xs text-[0.9rem] leading-relaxed text-ink/70">{{ $value['copy'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
