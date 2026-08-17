<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <title>Masuk — SMILJAN ADMIN</title>

        @vite(['resources/css/app.css'])
    </head>
    <body class="flex min-h-screen items-center justify-center bg-bg px-6">
        <div class="w-full max-w-sm">
            <a href="{{ route('home') }}" class="flex flex-col items-center leading-none">
                <span class="font-display text-[2rem] tracking-tight">SMILJAN</span>
                <span class="mt-1 font-mono text-[0.6rem] tracking-[0.32em] text-olive">SOUTHSPARE / ADMIN</span>
            </a>

            <form method="POST" action="{{ route('admin.authenticate') }}" class="mt-12">
                @csrf

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

                    <button type="submit" class="link-line inline-flex w-fit items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]">
                        Masuk <span aria-hidden="true">→</span>
                    </button>
                </div>
            </form>
        </div>
    </body>
</html>
