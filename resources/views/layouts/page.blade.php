<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('meta-description', 'Kopi, buku, ruang dan komunitas di selatan Jakarta. Smiljan Southspare — Jl. BDN 1, Cilandak Barat, Jakarta Selatan. Buka setiap hari 08:00—22:00.')">
        <meta name="theme-color" content="#e9e4d8">
        <title>@yield('title', 'SMILJAN SOUTHSPARE — Kopi, Buku &amp; Hari yang Lebih Pelan')</title>

        @php
            $pageTitle = $__env->yieldContent('title', 'SMILJAN SOUTHSPARE — Kopi, Buku & Hari yang Lebih Pelan');
            $pageDescription = $__env->yieldContent('meta-description', 'Kopi, buku, ruang dan komunitas di selatan Jakarta. Smiljan Southspare — Jl. BDN 1, Cilandak Barat, Jakarta Selatan. Buka setiap hari 08:00—22:00.');
            $pageImage = $__env->yieldContent('og-image', url('/images/hero-cafe.webp'));
        @endphp
        @include('partials.seo', compact('pageTitle', 'pageDescription', 'pageImage'))

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <a href="#main" class="skip-link">Langsung ke konten utama</a>
        <div class="cursor-dot" aria-hidden="true"></div>

        @include('partials.nav')

        <main id="main">
            @yield('content')
        </main>

        @include('partials.footer')
    </body>
</html>
