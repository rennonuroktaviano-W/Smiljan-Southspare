@extends('admin.layouts.admin')

@section('title', 'Profil Saya')

@section('content')
    <div class="max-w-lg">
        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-7">
                <div>
                    <label for="name" class="mb-2 block font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive">Nama</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                        class="w-full border border-ink/15 bg-bg px-3 py-2 font-mono text-[0.85rem] focus:border-wood focus:outline-none">
                    @error('name')
                        <p class="mt-1 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-2 block font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                        class="w-full border border-ink/15 bg-bg px-3 py-2 font-mono text-[0.85rem] focus:border-wood focus:outline-none">
                    @error('email')
                        <p class="mt-1 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-ink/10 pt-6">
                    <p class="mb-4 font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive">Ubah kata sandi (opsional)</p>
                </div>

                <div>
                    <label for="current_password" class="mb-2 block font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive">Kata sandi saat ini</label>
                    <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                        class="w-full border border-ink/15 bg-bg px-3 py-2 font-mono text-[0.85rem] focus:border-wood focus:outline-none">
                    @error('current_password')
                        <p class="mt-1 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive">Kata sandi baru</label>
                    <input id="password" name="password" type="password" autocomplete="new-password"
                        class="w-full border border-ink/15 bg-bg px-3 py-2 font-mono text-[0.85rem] focus:border-wood focus:outline-none">
                    @error('password')
                        <p class="mt-1 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive">Ulangi kata sandi baru</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                        class="w-full border border-ink/15 bg-bg px-3 py-2 font-mono text-[0.85rem] focus:border-wood focus:outline-none">
                </div>

                <button type="submit" class="link-line inline-flex w-fit items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]">
                    Simpan perubahan <span aria-hidden="true">→</span>
                </button>
            </div>
        </form>

        {{-- 2FA Section --}}
        <div class="mt-12 border-t border-ink/10 pt-8">
            <h2 class="font-display text-[1.5rem]">Dua Faktor Autentikasi</h2>
            <p class="mt-2 text-[0.9rem] text-ink/70">
                @if ($user->two_factor_enabled)
                    <span class="text-wood">Aktif</span> — Akun Anda dilindungi dengan verifikasi dua langkah (wajib).
                @else
                    <span class="text-coffee">Nonaktif</span> — Verifikasi dua langkah wajib diaktifkan untuk masuk.
                @endif
            </p>

            <div class="mt-6 flex gap-4">
                @if (! $user->two_factor_enabled)
                    <a href="{{ route('admin.two-factor.setup') }}" class="link-line inline-flex items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]">
                        Aktifkan 2FA <span aria-hidden="true">→</span>
                    </a>
                @elseif (! config('admin.two_factor.required', true))
                    <form method="POST" action="{{ route('admin.two-factor.disable') }}" data-confirm="Nonaktifkan 2FA? Login berikutnya akan memaksa Anda mengaktifkannya kembali.">
                        @csrf
                        @method('DELETE')
                        <div class="flex items-end gap-3">
                            <div>
                                <label for="disable_password" class="mb-1 block font-mono text-[0.6rem] uppercase tracking-[0.2em] text-olive">Masukkan password untuk konfirmasi</label>
                                <input id="disable_password" name="password" type="password" required placeholder="Password"
                                    class="border border-ink/15 bg-bg px-3 py-2 font-mono text-[0.8rem] focus:border-wood focus:outline-none">
                            </div>
                            <button type="submit" class="font-mono text-[0.7rem] uppercase tracking-[0.2em] text-coffee hover:text-ink">
                                Nonaktifkan
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
                        @enderror
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
