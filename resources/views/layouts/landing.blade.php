<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Kopi, buku, ruang dan komunitas di selatan Jakarta. Smiljan Southspare — Jl. BDN 1, Cilandak Barat, Jakarta Selatan. Buka setiap hari 08:00—22:00.">
        <meta name="theme-color" content="#171714">
        <title>SMILJAN SOUTHSPARE — Kopi, Buku &amp; Hari yang Lebih Pelan</title>

        @php
            $pageTitle = 'SMILJAN SOUTHSPARE — Kopi, Buku & Hari yang Lebih Pelan';
            $pageDescription = 'Kopi, buku, ruang dan komunitas di selatan Jakarta. Smiljan Southspare — Jl. BDN 1, Cilandak Barat, Jakarta Selatan. Buka setiap hari 08:00—22:00.';
            $pageImage = url('/images/hero-cafe.webp');
        @endphp
        @include('partials.seo', compact('pageTitle', 'pageDescription', 'pageImage'))

        <link rel="preload" as="image" href="{{ asset('images/hero-cafe.webp') }}" fetchpriority="high">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        {{-- Loading Screen --}}
        <div class="loader" aria-hidden="true">
            <span class="loader-brand">SMILJAN</span>
            <span class="loader-sub">SOUTHSPARE</span>
            <div class="loader-line"></div>
            <span class="loader-counter">000</span>
        </div>

        <a href="#main" class="skip-link">Langsung ke konten utama</a>
        <div class="cursor-dot" aria-hidden="true"></div>

        @include('partials.nav')

        <main id="main" class="page-enter">
            @include('partials.hero')
            @include('partials.manifesto')
            @include('partials.space')
            @include('partials.coffee')
            @include('partials.coffee-philosophy')
            @include('partials.books')
            @include('partials.community')
            @include('partials.journal')
            @include('partials.quote')
            @include('partials.visit')
        </main>

        @include('partials.footer')

        @include('partials.cookie-consent')

        <button type="button" class="back-to-top" aria-label="Kembali ke atas" data-cursor>↑</button>
    </body>
</html>
