@php
    $onHome = request()->routeIs('home');
    $navLinks = $onHome
        ? config('site.nav.items')
        : [
            ['label' => 'Jurnal',  'href' => route('journal.index')],
            ['label' => 'Menu',    'href' => route('menu')],
            ['label' => 'Tentang', 'href' => route('about')],
            ['label' => 'Kontak',  'href' => route('contact')],
        ];
@endphp

<header class="nav" data-nav>
    <div class="wrap flex items-center justify-between py-5 lg:py-6">
        <a href="{{ route('home') }}" class="flex flex-col leading-none" aria-label="Smiljan Southspare — kembali ke beranda">
            <span class="font-display text-[1.45rem] tracking-tight">SMILJAN</span>
            <span class="mt-1 font-mono text-[0.58rem] tracking-[0.32em] text-olive">SOUTHSPARE</span>
        </a>

        <nav class="hidden lg:flex items-center gap-9" aria-label="Navigasi utama">
            @foreach ($navLinks as $item)
                <a
                    href="{{ $item['href'] }}"
                    class="nav-link link-line font-mono text-[0.72rem] uppercase tracking-[0.24em] {{ request()->fullUrlIs(url($item['href'])) ? 'text-wood' : '' }}"
                    data-magnetic
                >{{ $item['label'] }}</a>
            @endforeach
            <span class="h-4 w-px bg-ink/15" aria-hidden="true"></span>
            <span class="font-mono text-[0.62rem] uppercase tracking-[0.24em] text-olive">{{ config('site.brand.area') }}</span>
        </nav>

        <div class="flex items-center gap-5">
            <div class="flex items-center gap-2.5" data-status data-open="{{ config('site.hours.open') }}" data-close="{{ config('site.hours.close') }}">
                <span class="status-dot" aria-hidden="true"></span>
                <span class="font-mono text-[0.62rem] uppercase tracking-[0.18em] whitespace-nowrap" data-status-text>—</span>
            </div>

            <button
                type="button"
                class="menu-btn lg:hidden flex flex-col items-end gap-1.5 p-1"
                data-menu-btn
                aria-label="Buka menu"
                aria-expanded="false"
                aria-controls="menu"
            >
                <span class="block h-px w-6 bg-ink"></span>
                <span class="block h-px w-4 bg-ink"></span>
            </button>
        </div>
    </div>
</header>

<div class="menu-overlay" id="menu" data-menu aria-hidden="true">
    <div class="wrap flex h-full flex-col py-5">
        <div class="flex items-center justify-between">
            <span class="font-display text-[1.45rem] leading-none">SMILJAN</span>
            <button
                type="button"
                class="menu-close p-2 font-mono text-[0.7rem] uppercase tracking-[0.24em]"
                data-menu-close
                aria-label="Tutup menu"
            >
                Tutup ✕
            </button>
        </div>

        <nav class="flex flex-1 flex-col justify-center gap-2" aria-label="Navigasi mobile">
            @foreach ($navLinks as $item)
                <a href="{{ $item['href'] }}" class="menu-item font-display text-[clamp(2.4rem,9vw,4rem)] leading-tight" style="--d: {{ 0.1 + $loop->index * 0.07 }}s">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="menu-item flex items-center justify-between border-t hairline-light pt-5 font-mono text-[0.6rem] uppercase tracking-[0.22em] text-paper/60" style="--d: 0.42s">
            <span>{{ config('site.brand.area') }}</span>
            <span>{{ config('site.brand.coords') }}</span>
        </div>
    </div>
</div>
