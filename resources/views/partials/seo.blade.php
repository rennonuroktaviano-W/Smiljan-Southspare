@php
    $pageTitle = $pageTitle ?? 'SMILJAN SOUTHSPARE — Kopi, Buku & Hari yang Lebih Pelan';
    $pageDescription = $pageDescription ?? 'Kopi, buku, ruang dan komunitas di selatan Jakarta.';
    $pageImage = $pageImage ?? url('/images/hero-cafe.webp');
    $pageUrl = $pageUrl ?? request()->url();
    $siteUrl = $siteUrl ?? url('/');

    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'CafeOrCoffeeShop',
        'name' => siteSetting('brand', 'name') . ' ' . siteSetting('brand', 'sub'),
        'url' => $siteUrl,
        'image' => url('/images/hero-cafe.webp'),
        'servesCuisine' => 'Kopi',
        'priceRange' => 'Rp 25.000 - Rp 45.000',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => siteSetting('address.lines.0'),
            'addressLocality' => siteSetting('address.lines.1'),
            'addressRegion' => siteSetting('address.lines.2'),
            'addressCountry' => 'ID',
        ],
        'openingHours' => 'Mo-Su ' . substr(siteSetting('hours', 'open'), 0, 5) . '-' . substr(siteSetting('hours', 'close'), 0, 5),
        'sameAs' => [siteSetting('social', 'instagram')],
    ];
@endphp

<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ siteSetting('brand', 'name') }} {{ siteSetting('brand', 'sub') }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:url" content="{{ $pageUrl }}">
<meta property="og:image" content="{{ $pageImage }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image" content="{{ $pageImage }}">
<link rel="canonical" href="{{ $pageUrl }}">

<script type="application/ld+json">{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}</script>

@stack('structured-data')
