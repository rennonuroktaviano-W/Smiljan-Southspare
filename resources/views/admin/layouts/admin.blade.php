<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <title>@yield('title', 'Admin') — SMILJAN SOUTHSPARE</title>

        @vite(['resources/css/app.css'])
    </head>
    <body class="min-h-screen bg-paper">
        <div class="flex min-h-screen">
            <aside class="flex w-60 flex-col border-r border-ink/10 bg-bg p-6 lg:w-64">
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

            <main class="flex-1 overflow-x-hidden p-6 lg:p-12">
                <header class="mb-10 flex flex-wrap items-baseline justify-between gap-4">
                    <h1 class="font-display text-[2rem] leading-none lg:text-[2.6rem]">@yield('title')</h1>
                    @yield('header-actions')
                </header>

                @if (session('ok'))
                    <div class="mb-8 border border-wood/40 bg-wood/5 p-4 text-[0.9rem] text-coffee">
                        {{ session('ok') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </body>
</html>
