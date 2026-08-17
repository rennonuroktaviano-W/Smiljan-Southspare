@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <a href="{{ route('admin.articles.index') }}" class="border border-ink/10 bg-bg p-6 transition-colors hover:border-wood/60">
            <p class="font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Artikel Jurnal</p>
            <p class="mt-3 font-display text-[2.6rem] leading-none">{{ $articles }}</p>
        </a>
        <a href="{{ route('admin.menu.index') }}" class="border border-ink/10 bg-bg p-6 transition-colors hover:border-wood/60">
            <p class="font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Item Menu</p>
            <p class="mt-3 font-display text-[2.6rem] leading-none">{{ $menuItems }}</p>
        </a>
        <a href="{{ route('admin.events.index') }}" class="border border-ink/10 bg-bg p-6 transition-colors hover:border-wood/60">
            <p class="font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Acara</p>
            <p class="mt-3 font-display text-[2.6rem] leading-none">{{ $events }}</p>
        </a>
        <a href="{{ route('admin.messages.index') }}" class="border border-ink/10 bg-bg p-6 transition-colors hover:border-wood/60">
            <p class="font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Pesan Belum Dibaca</p>
            <p class="mt-3 font-display text-[2.6rem] leading-none">{{ $unread }}</p>
        </a>
    </div>

    <section class="mt-12">
        <div class="flex items-baseline justify-between">
            <h2 class="font-display text-[1.5rem]">Pesan terbaru</h2>
            <a href="{{ route('admin.messages.index') }}" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive hover:text-ink">
                Semua pesan →
            </a>
        </div>

        <div class="mt-6 border-t border-ink/10">
            @forelse ($recentMessages as $message)
                <div class="flex flex-wrap items-baseline gap-4 border-b border-ink/10 py-4">
                    <span class="font-display text-[1.1rem]">{{ $message->name }}</span>
                    <span class="font-mono text-[0.6rem] tracking-[0.14em] text-olive">{{ $message->email }}</span>
                    <span class="ml-auto font-mono text-[0.6rem] text-olive">{{ $message->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <p class="py-6 text-[0.9rem] text-ink/60">Belum ada pesan masuk.</p>
            @endforelse
        </div>
    </section>
@endsection
