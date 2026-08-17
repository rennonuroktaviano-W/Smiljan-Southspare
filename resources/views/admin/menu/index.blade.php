@extends('admin.layouts.admin')

@section('title', 'Menu')

@section('header-actions')
    <a href="{{ route('admin.menu.create') }}" class="font-mono text-[0.7rem] uppercase tracking-[0.2em] text-olive hover:text-ink">
        + Item baru
    </a>
@endsection

@section('content')
    <div class="border-t border-ink/10">
        @forelse ($items as $item)
            <div class="flex flex-wrap items-center gap-4 border-b border-ink/10 py-4">
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-baseline gap-3">
                        <a href="{{ route('admin.menu.edit', $item) }}" class="font-display text-[1.15rem] leading-tight hover:text-wood">
                            {{ $item->name }}
                        </a>
                        <span class="font-mono text-[0.6rem] uppercase tracking-[0.18em] text-olive">{{ $item->category }}</span>
                        <span class="font-mono text-[0.6rem] text-olive">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        <span class="font-mono text-[0.6rem] uppercase tracking-[0.18em] {{ $item->is_coffee ? 'text-wood' : 'text-coffee' }}">
                            {{ $item->is_coffee ? 'Kopi' : 'Non-kopi' }}
                        </span>
                        @unless ($item->published)
                            <span class="font-mono text-[0.6rem] uppercase tracking-[0.18em] text-coffee">Draf</span>
                        @endunless
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <a href="{{ route('menu') }}" target="_blank" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive hover:text-ink">Lihat ↗</a>
                    <a href="{{ route('admin.menu.edit', $item) }}" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive hover:text-ink">Ubah</a>
                    <form method="POST" action="{{ route('admin.menu.destroy', $item) }}" onsubmit="return confirm('Hapus item ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-coffee hover:text-ink">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="py-8 text-[0.9rem] text-ink/60">Belum ada item menu.</p>
        @endforelse
    </div>
@endsection
