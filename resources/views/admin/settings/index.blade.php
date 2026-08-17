@extends('admin.layouts.admin')

@section('title', 'Pengaturan Situs')

@section('content')
    <p class="mb-8 text-[0.85rem] text-olive">Kelola semua konten halaman situs dari sini. Perubahan langsung terlihat di website.</p>

    <div class="border-t border-ink/10">
        @foreach ($sections as $key => $section)
            <a href="{{ route('admin.settings.edit', $key) }}" class="flex items-center justify-between border-b border-ink/10 py-5 transition-colors hover:bg-ink/[.02]">
                <div class="flex items-center gap-4">
                    <span class="flex h-8 w-8 items-center justify-center border border-ink/10 text-[0.8rem]">{{ $section['icon'] }}</span>
                    <div>
                        <span class="font-display text-[1.1rem]">{{ $section['label'] }}</span>
                        <span class="ml-3 font-mono text-[0.6rem] uppercase tracking-[0.2em] text-olive">{{ $key }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @if ($section['updated'])
                        <span class="font-mono text-[0.6rem] uppercase tracking-[0.18em] text-olive">{{ $section['updated'] }}</span>
                    @endif
                    <span class="font-mono text-[0.7rem] text-olive">Ubah →</span>
                </div>
            </a>
        @endforeach
    </div>
@endsection
