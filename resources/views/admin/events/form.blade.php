@extends('admin.layouts.admin')

@section('title', $event ? 'Ubah Acara' : 'Acara Baru')

@section('header-actions')
    <a href="{{ route('admin.events.index') }}" class="font-mono text-[0.7rem] uppercase tracking-[0.2em] text-olive hover:text-ink">
        ← Kembali
    </a>
@endsection

@section('content')
    <form method="POST" action="{{ $event ? route('admin.events.update', $event) : route('admin.events.store') }}" class="max-w-2xl">
        @csrf
        @if ($event)
            @method('PUT')
        @endif

        <div class="flex flex-col gap-7">
            <div>
                <label for="name" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Nama</label>
                <input id="name" name="name" type="text" required value="{{ old('name', $event->name ?? '') }}"
                    class="w-full border-b border-ink/15 bg-transparent pb-2 font-display text-[1.4rem] leading-none focus:border-wood focus:outline-none">
                @error('name')<p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Deskripsi</label>
                <textarea id="description" name="description" rows="2" required
                    class="w-full resize-none border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] leading-snug focus:border-wood focus:outline-none">{{ old('description', $event->description ?? '') }}</textarea>
                @error('description')<p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-3 gap-6">
                <div>
                    <label for="status" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Status</label>
                    <input id="status" name="status" type="text" required value="{{ old('status', $event->status ?? 'Segera') }}"
                        class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] focus:border-wood focus:outline-none">
                </div>
                <div>
                    <label for="event_date" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Tanggal (opsional)</label>
                    <input id="event_date" name="event_date" type="date" value="{{ old('event_date', $event?->event_date?->toDateString() ?? '') }}"
                        class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] focus:border-wood focus:outline-none">
                </div>
                <div>
                    <label for="sort_order" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Urutan</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $event->sort_order ?? 0) }}"
                        class="w-full border-b border-ink/15 bg-transparent pb-2 text-[0.95rem] focus:border-wood focus:outline-none">
                </div>
            </div>

            <button type="submit" class="link-line inline-flex w-fit items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]">
                Simpan acara <span aria-hidden="true">→</span>
            </button>
        </div>
    </form>
@endsection
