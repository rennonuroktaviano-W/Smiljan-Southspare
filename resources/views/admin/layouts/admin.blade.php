<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <title>@yield('title', 'Admin') — SMILJAN SOUTHSPARE</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-paper">
        <div class="flex min-h-screen">
            {{-- Mobile overlay --}}
            <div class="fixed inset-0 z-30 bg-ink/40 hidden lg:hidden" data-sidebar-overlay></div>

            {{-- Sidebar --}}
            <aside class="admin-sidebar flex w-60 flex-col border-r border-ink/10 bg-bg p-6 lg:w-64 lg:translate-x-0" data-sidebar>
                <a href="{{ route('admin.dashboard') }}" class="flex flex-col leading-none">
                    <span class="font-display text-[1.3rem] tracking-tight">SMILJAN</span>
                    <span class="mt-1 font-mono text-[0.55rem] tracking-[0.32em] text-olive">SOUTHSPARE / ADMIN</span>
                </a>

                <nav class="mt-10 flex flex-col gap-1" aria-label="Navigasi admin">
                    @foreach ($adminNav as $item)
                        <a
                            href="{{ $item['href'] }}"
                            class="flex items-center justify-between rounded px-3 py-2 font-mono text-[0.68rem] uppercase tracking-[0.2em] transition-colors duration-300 {{ request()->routeIs($item['active']) ? 'bg-ink text-paper' : 'text-olive hover:bg-ink/5 hover:text-ink' }}"
                        >
                            <span>{{ $item['label'] }}</span>
                            @if (! empty($item['badge']))
                                <span class="rounded-full bg-wood px-2 py-0.5 text-[0.55rem] text-paper">{{ $item['badge'] }}</span>
                            @endif
                        </a>
                    @endforeach
                </nav>

                <div class="mt-auto flex flex-col gap-3 border-t border-ink/10 pt-5">
                    <a href="{{ route('home') }}" target="_blank" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive transition-colors hover:text-ink">
                        Lihat situs ↗
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive transition-colors hover:text-ink">
                            Keluar
                        </button>
                    </form>
                </div>
            </aside>

            <main class="flex-1 overflow-x-hidden p-4 sm:p-6 lg:p-12 page-enter">
                {{-- Mobile header --}}
                <header class="mb-6 flex items-center gap-4 lg:mb-10 lg:hidden">
                    <button type="button" class="flex flex-col gap-1 p-2" data-sidebar-toggle aria-label="Buka menu">
                        <span class="block h-px w-5 bg-ink"></span>
                        <span class="block h-px w-4 bg-ink"></span>
                        <span class="block h-px w-3 bg-ink"></span>
                    </button>
                    <h1 class="font-display text-[1.5rem] leading-none">@yield('title')</h1>
                </header>

                {{-- Desktop header --}}
                <header class="mb-10 hidden flex-wrap items-baseline justify-between gap-4 lg:flex">
                    <h1 class="font-display text-[2rem] leading-none lg:text-[2.6rem]">@yield('title')</h1>
                    @yield('header-actions')
                </header>

                @if (session('ok'))
                    <div class="flash-msg mb-8 flex items-center justify-between border border-wood/40 bg-wood/5 p-4 text-[0.9rem] text-coffee" role="alert">
                        <span>{{ session('ok') }}</span>
                        <button type="button" class="ml-4 text-olive hover:text-ink" data-flash-close aria-label="Tutup">&times;</button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const sidebar = document.querySelector('[data-sidebar]');
                const overlay = document.querySelector('[data-sidebar-overlay]');
                const toggle = document.querySelector('[data-sidebar-toggle]');

                if (toggle && sidebar && overlay) {
                    toggle.addEventListener('click', () => {
                        sidebar.classList.toggle('is-open');
                        overlay.classList.toggle('hidden');
                    });
                    overlay.addEventListener('click', () => {
                        sidebar.classList.remove('is-open');
                        overlay.classList.add('hidden');
                    });
                }
            });
        </script>
    </body>
</html>
