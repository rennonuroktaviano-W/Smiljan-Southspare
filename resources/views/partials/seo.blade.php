@php
    $pageTitle = $pageTitle ?? 'SMILJAN SOUTHSPARE — Kopi, Buku &amp; Hari yang Lebih Pelan';
    $pageDescription = $pageDescription ?? 'Kopi, buku, ruang dan komunitas di selatan Jakarta. Smiljan Southspare — Jl. BDN 1, Cilandak Barat, Jakarta Selatan. Buka setiap hari 08:00—22:00.';
    $pageImage = $pageImage ?? url('/images/hero-cafe.webp');
    $pageUrl = $pageUrl ?? request()->url();
    $siteUrl = url('/');
@endphp

<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ config('site.brand.name') }} {{ config('site.brand.sub') }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:url" content="{{ $pageUrl }}">
<meta property="og:image" content="{{ $pageImage }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image" content="{{ $pageImage }}">
<link rel="canonical" href="{{ $pageUrl }}">

<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@type": "CafeOrCoffeeShop",
    "name": "{{ config('site.brand.name') }} {{ config('site.brand.sub') }}",
    "url": "{{ $siteUrl }}",
    "image": "{{ url('/images/hero-cafe.webp') }}",
    "servesCuisine": "Kopi",
    "priceRange": "Rp 25.000 - Rp 45.000",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ config('site.address.lines.0') }}",
        "addressLocality": "{{ config('site.address.lines.1') }}",
        "addressRegion": "{{ config('site.address.lines.2') }}",
        "addressCountry": "ID"
    },
    "openingHours": "Mo-Su {{ substr(config('site.hours.open'), 0, 5) }}-{{ substr(config('site.hours.close'), 0, 5) }}",
    "sameAs": ["{{ config('site.social.instagram') }}"]
}
</script>

@stack('structured-data')
