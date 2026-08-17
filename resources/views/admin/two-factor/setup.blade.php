@extends('admin.layouts.admin')

@section('title', 'Aktifkan Dua Faktor')

@section('content')
    <div class="max-w-lg">
        <p class="text-[0.95rem] leading-relaxed text-ink/80">
            Pindai kode QR di bawah ini menggunakan aplikasi autentikator Anda (Google Authenticator, Authy, dll.), lalu masukkan kode 6 digit untuk mengaktifkan.
        </p>

        <div class="mt-8 flex justify-center">
            <div class="border border-ink/10 bg-white p-4">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($qrCodeUrl) }}" alt="QR Code 2FA" width="200" height="200">
            </div>
        </div>

        <div class="mt-6 rounded border border-ink/10 bg-bg p-4">
            <p class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive">Kode manual</p>
            <p class="mt-2 font-mono text-[1rem] tracking-[0.15em] break-all">{{ $secret }}</p>
        </div>

        <form method="POST" action="{{ route('admin.two-factor.enable') }}" class="mt-8">
            @csrf
            <input type="hidden" name="secret" value="{{ $secret }}">

            <div>
                <label for="code" class="sr-only">Kode verifikasi</label>
                <input id="code" name="code" type="text" inputmode="numeric" pattern="[0-9]*" maxlength="6" placeholder="Masukkan kode 6 digit" required autofocus autocomplete="one-time-code"
                    class="w-full border-b border-ink/15 bg-transparent pb-2 font-mono text-[1.3rem] tracking-[0.3em] leading-none placeholder:text-ink/35 focus:border-wood focus:outline-none">
                @error('code')
                    <p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="link-line inline-flex items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]">
                    Aktifkan 2FA <span aria-hidden="true">→</span>
                </button>
                <a href="{{ route('admin.profile.edit') }}" class="inline-flex items-center font-mono text-[0.7rem] uppercase tracking-[0.2em] text-olive hover:text-ink">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
