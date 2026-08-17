@extends('layouts.page')

@section('title', $article['title'] . ' — SMILJAN SOUTHSPARE')
@section('meta-description', $article['excerpt'])

@push('structured-data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": "{{ $article['title'] }}",
    "description": "{{ $article['excerpt'] }}",
    "image": "{{ url($article['src']) }}",
    "datePublished": "{{ $article['date']->toIso8601String() }}",
    "mainEntityOfPage": "{{ url('/jurnal/'.$article['slug']) }}",
    "publisher": {
        "@type": "Organization",
        "name": "{{ config('site.brand.name') }} {{ config('site.brand.sub') }}"
    }
}
</script>
@endpush

@section('content')
    <article class="pt-32 lg:pt-44">
        <div class="wrap">
            <a href="{{ route('journal.index') }}" class="link-line inline-flex items-center gap-2 font-mono text-[0.68rem] uppercase tracking-[0.24em] text-olive" data-reveal>
                <span aria-hidden="true">←</span> Jurnal
            </a>

            <header class="mt-10 max-w-4xl">
                <div class="flex flex-wrap items-baseline gap-x-6 gap-y-2 font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive" data-reveal>
                    <span class="text-wood">{{ $article['category'] }}</span>
                    <span>{{ \Carbon\CarbonImmutable::parse($article['date'])->locale('id')->translatedFormat('d M Y') }}</span>
                    <span>{{ $article['meta'] }}</span>
                </div>

                <h1 class="mt-8 font-display text-[clamp(2.6rem,8.5vw,7rem)] leading-[0.9] tracking-[-0.01em]">
                    <span class="hero-line" style="--d: 0.1s">{{ $article['title'] }}</span>
                </h1>
            </header>

            <figure class="mt-14 lg:mt-20" data-reveal>
                <div class="img-frame aspect-[16/9]">
                    <img src="{{ asset($article['src']) }}" alt="{{ $article['alt'] }}" width="1400" height="788" fetchpriority="high" decoding="async">
                </div>
                <figcaption class="mt-3 flex justify-between font-mono text-[0.58rem] uppercase tracking-[0.22em] text-olive">
                    <span>FIG. — {{ config('site.brand.area') }}</span>
                    <span>{{ $article['category'] }} / JURNAL</span>
                </figcaption>
            </figure>

            <div class="mt-14 grid gap-10 lg:mt-20 lg:grid-cols-12">
                <div class="lg:col-span-2">
                    <p class="sticky top-28 font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive lg:mt-2" data-reveal>
                        {{ config('site.journal.label') }} / {{ config('site.journal.en') }}
                    </p>
                </div>

                <div class="lg:col-span-8 lg:col-start-4">
                    @foreach ($article['content'] as $block)
                        @if ($block['type'] === 'h')
                            <h2 class="mt-14 font-display text-[clamp(1.6rem,3.5vw,2.8rem)] leading-[1.05]" data-reveal>{{ $block['text'] }}</h2>
                        @elseif ($block['type'] === 'q')
                            <blockquote class="my-12 border-l border-wood pl-6 font-display text-[clamp(1.4rem,3vw,2.3rem)] leading-[1.1] text-coffee" data-reveal>
                                “{{ $block['text'] }}”
                            </blockquote>
                        @else
                            <p class="mt-8 max-w-2xl text-[1.05rem] leading-[1.85] text-ink/80" data-reveal>{{ $block['text'] }}</p>
                        @endif
                    @endforeach

                    <div class="mt-16 border-t pt-6 hairline" data-reveal>
                        <span class="font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">
                            {{ config('site.brand.name') }} {{ config('site.brand.sub') }} — {{ config('site.brand.area') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <nav class="wrap mt-20 border-t hairline lg:mt-28" aria-label="Artikel lain">
            <div class="grid gap-px sm:grid-cols-2">
                @if ($previous)
                    <a href="{{ route('journal.show', $previous['slug']) }}" class="group flex flex-col gap-3 py-10 pr-6" data-reveal>
                        <span class="font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">← Artikel sebelumnya</span>
                        <span class="font-display text-[clamp(1.4rem,3vw,2.4rem)] leading-[1.02] transition-colors duration-500 group-hover:text-wood">{{ $previous['title'] }}</span>
                    </a>
                @else
                    <span class="py-10 pr-6" data-reveal></span>
                @endif

                @if ($next)
                    <a href="{{ route('journal.show', $next['slug']) }}" class="group flex flex-col gap-3 border-t py-10 pl-6 text-right sm:border-t-0 sm:border-l hairline" data-reveal>
                        <span class="font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Artikel selanjutnya →</span>
                        <span class="font-display text-[clamp(1.4rem,3vw,2.4rem)] leading-[1.02] transition-colors duration-500 group-hover:text-wood">{{ $next['title'] }}</span>
                    </a>
                @else
                    <span class="py-10 pl-6" data-reveal></span>
                @endif
            </div>
        </nav>
    </article>
@endsection
