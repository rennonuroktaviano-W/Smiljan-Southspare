@extends('admin.auth.layout')

@section('title', 'Reset Kata Sandi')

@section('content')
    <form method="POST" action="{{ route('admin.password.update') }}" class="mt-8">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        @include('partials.honeypot')

        <div class="flex flex-col gap-7">
            <div>
                <label for="email" class="sr-only">Email</label>
                <input id="email" name="email" type="email" value="{{ $email }}" placeholder="Email" required autocomplete="email"
                    class="w-full border-b border-ink/15 bg-transparent pb-2 font-display text-[1.3rem] leading-none placeholder:text-ink/35 focus:border-wood focus:outline-none">
                @error('email')
                    <p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="sr-only">Kata sandi baru</label>
                <input id="password" name="password" type="password" placeholder="Kata sandi baru" required autocomplete="new-password"
                    class="w-full border-b border-ink/15 bg-transparent pb-2 font-display text-[1.3rem] leading-none placeholder:text-ink/35 focus:border-wood focus:outline-none">
                @error('password')
                    <p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="sr-only">Ulangi kata sandi</label>
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi kata sandi" required autocomplete="new-password"
                    class="w-full border-b border-ink/15 bg-transparent pb-2 font-display text-[1.3rem] leading-none placeholder:text-ink/35 focus:border-wood focus:outline-none">
            </div>

            @include('partials.turnstile')

            <button type="submit" class="link-line inline-flex w-full justify-center items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]">
                Reset kata sandi <span aria-hidden="true">→</span>
            </button>
        </div>
    </form>
@endsection
