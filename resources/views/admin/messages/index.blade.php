@extends('admin.layouts.admin')

@section('title', 'Pesan Masuk')

@section('content')
    <div class="border-t border-ink/10">
        @forelse ($messages as $message)
            <div class="flex flex-wrap gap-6 border-b border-ink/10 py-6 {{ $message->is_read ? '' : 'bg-wood/5' }}">
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
@endsection
