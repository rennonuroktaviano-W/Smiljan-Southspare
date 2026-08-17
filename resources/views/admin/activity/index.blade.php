@extends('admin.layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="border-t border-ink/10">
        @forelse ($activities as $activity)
            <div class="flex flex-wrap items-start gap-4 border-b border-ink/10 py-5 transition-colors hover:bg-ink/[.02]">
                <div class="min-w-0 flex-1">
                    <p class="text-[0.95rem] text-ink/80">{{ $activity->description }}</p>
                    <p class="mt-1 flex flex-wrap items-baseline gap-x-4 font-mono text-[0.6rem] uppercase tracking-[0.18em] text-olive">
                        @if ($activity->causer)
                            <span>Oleh: {{ $activity->causer->name }}</span>
                        @endif
                        @if ($activity->event)
                            <span>{{ $activity->event }}</span>
                        @endif
                        <span>{{ $activity->created_at->translatedFormat('d M Y H:i:s') }}</span>
                    </p>
                </div>
            </div>
        @empty
            <p class="py-8 text-[0.9rem] text-ink/60">Belum ada aktivitas.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $activities->links() }}
    </div>
@endsection
