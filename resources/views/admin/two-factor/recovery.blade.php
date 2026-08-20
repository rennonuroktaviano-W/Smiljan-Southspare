@extends('admin.layouts.admin')

@section('title', 'Kode Pemulihan')

@section('content')
    <div class="max-w-lg">
        <p class="text-[0.95rem] leading-relaxed text-ink/80">
            2FA berhasil diaktifkan. Kode pemulihan di bawah ini <strong>hanya ditampilkan sekali</strong> — simpan di tempat yang aman.
            Setiap kode hanya bisa dipakai satu kali untuk masuk ketika aplikasi autentikator tidak tersedia.
        </p>

        <div class="mt-8 grid grid-cols-1 gap-3 sm:grid-cols-2">
            @foreach ($codes as $code)
                <div class="border border-ink/10 bg-bg px-4 py-3 text-center font-mono text-[1rem] tracking-[0.15em]">
                    {{ $code }}
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('admin.two-factor.recovery.confirm') }}" class="mt-8">
            @csrf
            <button type="submit" class="link-line inline-flex items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]">
                Saya sudah menyimpannya, lanjutkan <span aria-hidden="true">→</span>
            </button>
        </form>
    </div>
@endsection
