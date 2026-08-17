@extends('admin.layouts.admin')

@section('title', 'Acara')

@section('header-actions')
    <a href="{{ route('admin.events.create') }}" class="font-mono text-[0.7rem] uppercase tracking-[0.2em] text-olive hover:text-ink">
        + Acara baru
    </a>
@endsection

@section('content')
    {{-- Search --}}
    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari acara..."
            class="flex-1 min-w-[200px] border border-ink/15 bg-bg px-3 py-2 font-mono text-[0.75rem] focus:border-wood focus:outline-none">
        <button type="submit" class="border border-ink/15 bg-bg px-4 py-2 font-mono text-[0.7rem] uppercase tracking-[0.18em] hover:bg-ink/5">
            Cari
        </button>
        @if (request('q'))
            <a href="{{ route('admin.events.index') }}" class="flex items-center px-3 py-2 font-mono text-[0.7rem] text-olive hover:text-ink">
                Reset
            </a>
        @endif
    </form>

    <div class="border-t border-ink/10">
        @forelse ($events as $event)
            <div class="flex flex-wrap items-center gap-4 border-b border-ink/10 py-5 transition-colors hover:bg-ink/[.02]">
                <div class="min-w-0 flex-1">
                    <a href="{{ route('admin.events.edit', $event) }}" class="font-display text-[1.2rem] leading-tight hover:text-wood">
                        {{ $event->name }}
                    </a>
                    <p class="mt-1 flex flex-wrap items-baseline gap-x-4 gap-y-1 font-mono text-[0.6rem] uppercase tracking-[0.18em] text-olive">
                        <span>{{ $event->status }}</span>
                        @if ($event->event_date)
                            <span>{{ $event->event_date->translatedFormat('d M Y') }}</span>
                        @endif
                    </p>
                </div>
                <div class="flex items-center gap-5">
                    <a href="{{ route('home').'#komunitas' }}" target="_blank" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive hover:text-ink">Lihat ↗</a>
                    <a href="{{ route('admin.events.edit', $event) }}" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive hover:text-ink">Ubah</a>
                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" data-confirm="Hapus acara ini?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-coffee hover:text-ink">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="py-8 text-[0.9rem] text-ink/60">Belum ada acara.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>
@endsection
