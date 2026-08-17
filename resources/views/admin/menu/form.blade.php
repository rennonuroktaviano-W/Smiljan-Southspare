@extends('admin.layouts.admin')

@section('title', $item ? 'Ubah Menu' : 'Item Baru')

@section('header-actions')
    <a href="{{ route('admin.menu.index') }}" class="font-mono text-[0.7rem] uppercase tracking-[0.2em] text-olive hover:text-ink">
        ← Kembali
    </a>
@endsection

@section('content')
    <form method="POST" action="{{ $item ? route('admin.menu.update', $item) : route('admin.menu.store') }}" class="max-w-2xl">
        @csrf
        @if ($item)
            @method('PUT')
        @endif

        <div class="flex flex-col gap-7">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="category" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Kategori</label>
                    <input id="category" name="category" type="text" required value="{{ old('category', $item->category ?? '') }}"
                        class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] focus:border-wood focus:outline-none">
                    @error('category')<p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="category_note" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Catatan kategori</label>
                    <input id="category_note" name="category_note" type="text" value="{{ old('category_note', $item->category_note ?? '') }}"
                        class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] focus:border-wood focus:outline-none">
                </div>
            </div>

            <div>
                <label for="name" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Nama</label>
                <input id="name" name="name" type="text" required value="{{ old('name', $item->name ?? '') }}"
                    class="w-full border-b border-ink/15 bg-transparent pb-2 font-display text-[1.4rem] leading-none focus:border-wood focus:outline-none">
                @error('name')<p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Deskripsi</label>
                <textarea id="description" name="description" rows="2" required
                    class="w-full resize-none border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] leading-snug focus:border-wood focus:outline-none">{{ old('description', $item->description ?? '') }}</textarea>
                @error('description')<p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="price" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Harga (Rp)</label>
                    <input id="price" name="price" type="number" min="0" step="500" required value="{{ old('price', $item->price ?? '') }}"
                        class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] focus:border-wood focus:outline-none">
                    @error('price')<p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="sort_order" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Urutan</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $item->sort_order ?? 0) }}"
                        class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] focus:border-wood focus:outline-none">
                </div>
            </div>

            <div class="flex flex-wrap gap-8">
                <label class="flex cursor-pointer items-center gap-3 text-[0.9rem]">
                    <input type="checkbox" name="is_coffee" value="1" class="accent-wood" @checked(old('is_coffee', $item->is_coffee ?? true))>
                    Kategori kopi
                </label>
                <label class="flex cursor-pointer items-center gap-3 text-[0.9rem]">
                    <input type="checkbox" name="published" value="1" class="accent-wood" @checked(old('published', $item->published ?? true))>
                    Tampilkan
                </label>
            </div>

            <button type="submit" class="link-line inline-flex w-fit items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]">
                Simpan menu <span aria-hidden="true">→</span>
            </button>
        </div>
    </form>
@endsection
