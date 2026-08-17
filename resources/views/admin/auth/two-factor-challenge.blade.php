@extends('admin.auth.layout')

@section('title', 'Verifikasi Dua Faktor')

@section('content')
    <p class="mt-6 text-center text-[0.9rem] text-olive">Masukkan kode 6 digit dari aplikasi autentikator Anda.</p>

    <form method="POST" action="{{ route('admin.two-factor.verify') }}" class="mt-8">
        @csrf

        <div>
            <label for="code" class="sr-only">Kode verifikasi</label>
            <input id="code" name="code" type="text" inputmode="numeric" pattern="[0-9]*" maxlength="6" placeholder="000000" required autofocus autocomplete="one-time-code"
                class="w-full border-b border-ink/15 bg-transparent pb-2 text-center font-mono text-[2rem] tracking-[0.5em] leading-none placeholder:text-ink/35 focus:border-wood focus:outline-none">
            @error('code')
                <p class="mt-2 text-center font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="mt-8 link-line inline-flex w-full justify-center items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]">
            Verifikasi <span aria-hidden="true">→</span>
        </button>
    </form>
@endsection
