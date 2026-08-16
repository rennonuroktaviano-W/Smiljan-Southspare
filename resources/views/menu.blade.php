@extends('layouts.page')

@section('title', 'Menu — SMILJAN SOUTHSPARE')
@section('meta-description', 'Menu kopi Smiljan Southspare — pilihan ringkas, diseduh dengan teliti. Espresso, filter, milk-based, dan rotasi musiman.')

@section('content')
    <section class="pt-32 lg:pt-44">
        <div class="wrap">
            <div class="flex items-baseline justify-between font-mono text-[0.62rem] uppercase tracking-[0.26em]">
                <span class="text-olive" data-reveal>{{ config('site.coffee.index') }} / {{ config('site.coffee.label') }}</span>
                <span class="hidden sm:inline" data-reveal>{{ config('site.coffee.en') }}</span>
            </div>

            <div class="mt-14 grid gap-8 lg:mt-20 lg:grid-cols-12 lg:items-end">
                <h1 class="font-display text-[clamp(2.6rem,9vw,7.5rem)] leading-[0.9] tracking-[-0.01em] lg:col-span-8">
                    @foreach (config('site.coffee.title') as $index => $line)
                        <span class="hero-line block whitespace-nowrap" style="--d: {{ 0.08 + $index * 0.11 }}s">{{ $line }}</span>
                    @endforeach
                </h1>
                <p class="max-w-sm text-[1.02rem] leading-relaxed text-ink/75 lg:col-span-4" data-reveal style="--d: 0.4s">
                    {{ config('site.coffee.copy') }}
                </p>
            </div>
        </div>
    </section>

    <section class="pb-28 lg:pb-44">
        <div class="wrap">
            <div class="mt-16 grid gap-14 lg:mt-24 lg:grid-cols-12">
                <div class="lg:col-span-7">
                    @foreach (config('site.coffee.categories') as $category)
                        <section class="border-t pt-6 hairline" data-reveal>
                            <div class="flex items-baseline justify-between gap-4">
                                <h2 class="font-mono text-[0.75rem] uppercase tracking-[0.28em]">{{ $category['name'] }}</h2>
                                <span class="font-mono text-[0.58rem] uppercase tracking-[0.2em] text-olive">{{ $category['note'] }}</span>
                            </div>
                            <ul class="mt-3">
                                @foreach ($category['items'] as $item)
                                    <li class="flex items-baseline gap-4 border-b border-ink/10 py-4 last:border-b-0">
                                        <span class="font-display text-[1.35rem] leading-none lg:text-[1.6rem]">{{ $item['name'] }}</span>
                                        <span class="hidden flex-1 border-b border-dotted border-ink/20 sm:block" aria-hidden="true"></span>
                                        <span class="max-w-[12rem] text-right text-[0.78rem] leading-snug text-ink/65">{{ $item['desc'] }}</span>
                                        <span class="w-20 text-right font-mono text-[0.7rem] text-olive whitespace-nowrap">
                                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </section>
                    @endforeach

                    <p class="mt-8 font-mono text-[0.58rem] uppercase tracking-[0.22em] text-olive" data-reveal>
                        HARGA SUDAH TERMASUK PAJAK · MENU NON-KOPI MENYUSUL
                    </p>
                </div>

                <aside class="lg:col-span-5 lg:pl-6">
                    <div class="lg:sticky lg:top-28">
                        <figure class="img-frame aspect-[3/4]" data-reveal>
                            <img src="{{ asset(config('site.coffee.image.src')) }}" alt="{{ config('site.coffee.image.alt') }}" width="800" height="1067" loading="lazy" decoding="async">
                        </figure>
                        <figcaption class="mt-3 flex justify-between font-mono text-[0.58rem] uppercase tracking-[0.22em] text-olive">
                            <span>FIG. 01 — FILTER</span>
                            <span>V60</span>
                        </figcaption>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
