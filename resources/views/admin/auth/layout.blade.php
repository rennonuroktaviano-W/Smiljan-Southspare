<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <title>@yield('title') — SMILJAN ADMIN</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen items-center justify-center bg-bg px-6">
        <div class="w-full max-w-sm page-enter">
            <a href="{{ route('home') }}" class="flex flex-col items-center leading-none">
                <span class="font-display text-[2rem] tracking-tight">SMILJAN</span>
                <span class="mt-1 font-mono text-[0.6rem] tracking-[0.32em] text-olive">SOUTHSPARE / ADMIN</span>
            </a>

            @if ($errors->any())
                <div class="mt-8 border border-coffee/30 bg-coffee/5 p-4 text-[0.85rem] text-coffee" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </div>
    </body>
</html>
