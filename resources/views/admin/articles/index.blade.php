@extends('admin.layouts.admin')

@section('title', 'Artikel Jurnal')

@section('header-actions')
    <a href="{{ route('admin.articles.create') }}" class="font-mono text-[0.7rem] uppercase tracking-[0.2em] text-olive hover:text-ink">
        + Artikel baru
    </a>
@endsection

@section('content')
    <div class="border-t border-ink/10">
        @forelse ($articles as $article)
            <div class="flex flex-wrap items-center gap-4 border-b border-ink/10 py-5">
                <div class="min-w-0 flex-1">
                    <a href="{{ route('admin.articles.edit', $article) }}" class="font-display text-[1.25rem] leading-tight hover:text-wood">
                        {{ $article->title }}
                    </a>
                    <p class="mt-1 flex flex-wrap items-baseline gap-x-4 gap-y-1 font-mono text-[0.6rem] uppercase tracking-[0.18em] text-olive">
                        <span>{{ $article->category }}</span>
                        <span>{{ $article->date->translatedFormat('d M Y') }}</span>
                        <span class="{{ $article->published ? 'text-wood' : 'text-coffee' }}">{{ $article->published ? 'Terbit' : 'Draf' }}</span>
                    </p>
                </div>
                <div class="flex items-center gap-5">
                    <a href="{{ route('journal.show', $article->slug) }}" target="_blank" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive hover:text-ink">
                        Lihat ↗
                    </a>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-olive hover:text-ink">
                        Ubah
                    </a>
                    <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Hapus artikel ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-coffee hover:text-ink">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="py-8 text-[0.9rem] text-ink/60">Belum ada artikel. Buat yang pertama.</p>
        @endforelse
    </div>
@endsection
