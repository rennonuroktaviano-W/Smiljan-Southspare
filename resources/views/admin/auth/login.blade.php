<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <title>Masuk — SMILJAN ADMIN</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen items-center justify-center bg-bg px-6">
        <div class="w-full max-w-sm page-enter">
            <a href="{{ route('home') }}" class="flex flex-col items-center leading-none">
                <span class="font-display text-[2rem] tracking-tight">SMILJAN</span>
                <span class="mt-1 font-mono text-[0.6rem] tracking-[0.32em] text-olive">SOUTHSPARE / ADMIN</span>
            </a>

            @if (session('two_factor'))
                <div class="mt-8 border border-wood/40 bg-wood/5 p-4 text-center text-[0.85rem] text-coffee">
                    {{ session('two_factor') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-8 border border-coffee/30 bg-coffee/5 p-4 text-[0.85rem] text-coffee" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.authenticate') }}" class="mt-10" autocomplete="on">
                @csrf

                @include('partials.honeypot')

                <div class="flex flex-col gap-7">
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="Email"
                            required
                            autofocus
                            autocomplete="email"
                            class="w-full border-b border-ink/15 bg-transparent pb-2 font-display text-[1.3rem] leading-none placeholder:text-ink/35 focus:border-wood focus:outline-none"
                        >
                        @error('email')
                            <p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="sr-only">Kata sandi</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Kata sandi"
                            required
                            autocomplete="current-password"
                            class="w-full border-b border-ink/15 bg-transparent pb-2 font-display text-[1.3rem] leading-none placeholder:text-ink/35 focus:border-wood focus:outline-none"
                        >
                    </div>

                    <p class="text-[0.8rem] leading-relaxed text-olive">Setelah password benar, Anda harus menyelesaikan verifikasi dua langkah untuk masuk.</p>

                    @include('partials.turnstile')

                    <button type="submit" class="link-line inline-flex w-fit items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]">
                        Masuk <span aria-hidden="true">→</span>
                    </button>
                </div>
            </form>
        </div>
    </body>
</html>
