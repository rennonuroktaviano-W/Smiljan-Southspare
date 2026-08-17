@extends('admin.layouts.admin')

@section('title', $article ? 'Ubah Artikel' : 'Artikel Baru')

@section('header-actions')
    <a href="{{ route('admin.articles.index') }}" class="font-mono text-[0.7rem] uppercase tracking-[0.2em] text-olive hover:text-ink">
        ← Kembali
    </a>
@endsection

@section('content')
    <form method="POST" action="{{ $article ? route('admin.articles.update', $article) : route('admin.articles.store') }}" class="grid gap-x-10 gap-y-8 lg:grid-cols-12">
        @csrf
        @if ($article)
            @method('PUT')
        @endif

        <div class="flex flex-col gap-7 lg:col-span-5">
            @php
                $contentText = $article ? \App\Http\Controllers\Admin\ArticleController::blocksToText($article->content) : null;
            @endphp

            <div>
                <label for="title" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Judul</label>
                <input id="title" name="title" type="text" required value="{{ old('title', $article->title ?? '') }}"
                    class="w-full border-b border-ink/15 bg-transparent pb-2 font-display text-[1.5rem] leading-none focus:border-wood focus:outline-none">
                @error('title')<p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="category" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Kategori</label>
                    <input id="category" name="category" type="text" required value="{{ old('category', $article->category ?? '') }}"
                        class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] focus:border-wood focus:outline-none">
                </div>
                <div>
                    <label for="meta" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Meta (baca)</label>
                    <input id="meta" name="meta" type="text" required value="{{ old('meta', $article->meta ?? '') }}"
                        class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] focus:border-wood focus:outline-none">
                </div>
            </div>

            <div>
                <label for="slug" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Slug (kosongkan untuk otomatis)</label>
                <input id="slug" name="slug" type="text" value="{{ old('slug', $article->slug ?? '') }}"
                    class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] focus:border-wood focus:outline-none">
            </div>

            <div>
                <label for="excerpt" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Ringkasan</label>
                <textarea id="excerpt" name="excerpt" rows="2" required
                    class="w-full resize-none border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] leading-snug focus:border-wood focus:outline-none">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="date" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Tanggal</label>
                    <input id="date" name="date" type="date" required value="{{ old('date', $article?->date?->toDateString() ?? now()->toDateString()) }}"
                        class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] focus:border-wood focus:outline-none">
                </div>
                <div>
                    <label for="sort_order" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Urutan</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $article->sort_order ?? 0) }}"
                        class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] focus:border-wood focus:outline-none">
                </div>
            </div>

            <div class="flex flex-wrap gap-8">
                <label class="flex cursor-pointer items-center gap-3 text-[0.9rem]">
                    <input type="checkbox" name="published" value="1" class="accent-wood" @checked(old('published', $article->published ?? true))>
                    Terbitkan
                </label>
            </div>
        </div>

        <div class="flex flex-col gap-7 lg:col-span-7">
            <div>
                <label for="content" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">
                    Isi artikel — satu paragraf per baris, awali dengan "&gt; " untuk kutipan
                </label>
                <textarea id="content" name="content" rows="18" required
                    class="w-full resize-y border border-ink/15 bg-bg p-4 font-mono text-[0.85rem] leading-relaxed focus:border-wood focus:outline-none">{{ old('content', $contentText) }}</textarea>
                @error('content')<p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="image_src" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Gambar (path)</label>
                    <input id="image_src" name="image_src" type="text" required value="{{ old('image_src', $article->image_src ?? '') }}"
                        class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.85rem] focus:border-wood focus:outline-none">
                </div>
                <div>
                    <label for="image_alt" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Alt teks</label>
                    <input id="image_alt" name="image_alt" type="text" required value="{{ old('image_alt', $article->image_alt ?? '') }}"
                        class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.85rem] focus:border-wood focus:outline-none">
                </div>
            </div>

            <button type="submit" class="link-line inline-flex w-fit items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]">
                Simpan artikel <span aria-hidden="true">→</span>
            </button>
        </div>
    </form>
@endsection
