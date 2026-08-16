<footer class="overflow-hidden bg-dark text-paper">
    <div class="wrap pt-24 lg:pt-32">
        <div class="grid gap-12 border-b hairline-light pb-16 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <p class="font-display text-2xl leading-none">SMILJAN</p>
                <p class="mt-3 font-mono text-[0.6rem] uppercase tracking-[0.3em] text-paper/60">
                    {{ config('site.brand.sub') }}<br>CILANDAK<br>JAKARTA
                </p>
            </div>

            <nav class="lg:col-span-2 lg:col-start-6" aria-label="Halaman">
                <ul class="flex flex-col gap-4">
                    @foreach ([
                        ['label' => 'Beranda', 'href' => route('home')],
                        ['label' => 'Jurnal',  'href' => route('journal.index')],
                        ['label' => 'Menu',    'href' => route('menu')],
                        ['label' => 'Tentang', 'href' => route('about')],
                        ['label' => 'Kontak',  'href' => route('contact')],
                    ] as $link)
                        <li>
                            <a href="{{ $link['href'] }}" class="link-line font-mono text-[0.72rem] uppercase tracking-[0.26em]">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <nav class="lg:col-span-3" aria-label="Tautan eksternal">
                <ul class="flex flex-col gap-4">
                    @foreach (config('site.footer.links') as $link)
                        <li>
                            <a href="{{ $link['href'] }}" target="_blank" rel="noopener" class="link-line font-mono text-[0.72rem] uppercase tracking-[0.26em]">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="lg:col-span-3">
                <p class="font-mono text-[0.62rem] uppercase tracking-[0.26em] text-paper/60">
                    {{ config('site.brand.coords') }}
                </p>
                <p class="mt-4 font-mono text-[0.62rem] uppercase tracking-[0.26em] text-paper/60">
                    {{ config('site.hours.open') }} — {{ config('site.hours.close') }}
                </p>
            </div>
        </div>
    </div>

    <div class="relative">
        <p class="fade-text select-none text-center font-display text-[clamp(4.5rem,24vw,22rem)] leading-[0.82] tracking-[-0.02em]" aria-hidden="true">
            {{ config('site.brand.name') }}
        </p>
    </div>

    <div class="border-t hairline-light">
        <div class="wrap flex flex-col gap-2 py-6 font-mono text-[0.58rem] uppercase tracking-[0.22em] text-paper/55 sm:flex-row sm:items-center sm:justify-between">
            <span>{{ config('site.brand.manifesto') }}</span>
            <span>© {{ date('Y') }} SOUTHSPARE</span>
        </div>
    </div>
</footer>
