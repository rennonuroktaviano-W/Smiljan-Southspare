@extends('admin.layouts.admin')

@section('title', 'Pesan Masuk')

@section('content')
    {{-- Search & Filter --}}
    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari pesan..."
            class="flex-1 min-w-[200px] border border-ink/15 bg-bg px-3 py-2 font-mono text-[0.75rem] focus:border-wood focus:outline-none">
        <select name="filter" class="border border-ink/15 bg-bg px-3 py-2 font-mono text-[0.75rem] focus:border-wood focus:outline-none">
            <option value="">Semua</option>
            <option value="unread" @selected(request('filter') === 'unread')>Belum dibaca</option>
            <option value="read" @selected(request('filter') === 'read')>Sudah dibaca</option>
        </select>
        <button type="submit" class="border border-ink/15 bg-bg px-4 py-2 font-mono text-[0.7rem] uppercase tracking-[0.18em] hover:bg-ink/5">
            Cari
        </button>
        @if (request('q') || request('filter'))
            <a href="{{ route('admin.messages.index') }}" class="flex items-center px-3 py-2 font-mono text-[0.7rem] text-olive hover:text-ink">
                Reset
            </a>
        @endif
    </form>

    <div class="border-t border-ink/10">
        @forelse ($messages as $message)
            <div class="flex flex-wrap gap-6 border-b border-ink/10 py-6 transition-colors hover:bg-ink/[.02] {{ $message->is_read ? '' : 'bg-wood/5' }}">
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-baseline gap-x-4 gap-y-1">
                        <span class="font-display text-[1.2rem]">{{ $message->name }}</span>
                        <a href="mailto:{{ $message->email }}" class="font-mono text-[0.65rem] tracking-[0.14em] text-olive hover:text-wood">
                            {{ $message->email }}
                        </a>
                        <span class="ml-auto font-mono text-[0.6rem] text-olive">{{ $message->created_at->translatedFormat('d M Y H:i') }}</span>
                    </div>
                    <p class="mt-3 max-w-3xl whitespace-pre-line text-[0.95rem] leading-relaxed text-ink/80">{{ $message->message }}</p>
                </div>
                <div class="flex flex-none items-center gap-5">
                    @unless ($message->is_read)
                        <form method="POST" action="{{ route('admin.messages.read', $message) }}">
                            @csrf
                            <button type="submit" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive hover:text-ink">Tandai dibaca</button>
                        </form>
                    @endunless
                    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Hapus pesan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-coffee hover:text-ink">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="py-8 text-[0.9rem] text-ink/60">Belum ada pesan.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $messages->links() }}
    </div>
@endsection
