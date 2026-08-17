@extends('admin.auth.layout')

@section('title', 'Lupa Kata Sandi')

@section('content')
    <p class="mt-6 text-center text-[0.9rem] text-olive">Masukkan email Anda dan kami akan mengirimkan tautan untuk reset kata sandi.</p>

    @if (session('ok'))
        <div class="mt-6 border border-wood/40 bg-wood/5 p-4 text-center text-[0.85rem] text-coffee">
            {{ session('ok') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.password.email') }}" class="mt-8">
        @csrf

        <div>
            <label for="email" class="sr-only">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Email" required autofocus autocomplete="email"
                class="w-full border-b border-ink/15 bg-transparent pb-2 font-display text-[1.3rem] leading-none placeholder:text-ink/35 focus:border-wood focus:outline-none">
            @error('email')
                <p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="mt-8 link-line inline-flex w-full justify-center items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]">
            Kirim tautan reset <span aria-hidden="true">→</span>
        </button>
    </form>

    <p class="mt-8 text-center">
        <a href="{{ route('admin.login') }}" class="font-mono text-[0.7rem] uppercase tracking-[0.2em] text-olive hover:text-ink">
            ← Kembali ke masuk
        </a>
    </p>
@endsection
