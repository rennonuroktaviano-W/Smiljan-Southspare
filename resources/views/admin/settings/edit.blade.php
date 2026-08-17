@extends('admin.layouts.admin')

@section('title', 'Ubah: ' . $meta['label'])

@section('header-actions')
    <a href="{{ route('admin.settings.index') }}" class="font-mono text-[0.7rem] uppercase tracking-[0.2em] text-olive hover:text-ink">
        ← Kembali
    </a>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.settings.update', $section) }}">
        @csrf
        @method('PUT')

        <div class="flex flex-col gap-8 max-w-3xl">
            @php $i = 0; @endphp

            {{-- BRAND --}}
            @if ($section === 'brand')
                @foreach (['name' => 'Nama Brand', 'sub' => 'Subtitle', 'area' => 'Area', 'coords' => 'Koordinat', 'manifesto' => 'Manifesto'] as $field => $label)
                    @include('admin.settings._field', ['key' => "value[{$field}]", 'label' => $label, 'value' => data_get($value, $field), 'type' => 'text'])
                @endforeach

            {{-- ADDRESS --}}
            @elseif ($section === 'address')
                <div>
                    <label class="mb-3 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Alamat</label>
                    @foreach (data_get($value, 'lines', ['']) as $line)
                        @include('admin.settings._field', ['key' => "value[lines][]", 'label' => null, 'value' => $line, 'type' => 'text', 'placeholder' => 'Baris alamat'])
                    @endforeach
                    @include('admin.settings._field', ['key' => 'value[lines][]', 'label' => 'Tambah baris', 'value' => '', 'type' => 'text', 'placeholder' => 'Baris baru (kosongkan jika tidak perlu)'])
                </div>
                @include('admin.settings._field', ['key' => 'value[maps_url]', 'label' => 'Google Maps URL', 'value' => data_get($value, 'maps_url'), 'type' => 'url'])

            {{-- HOURS --}}
            @elseif ($section === 'hours')
                @include('admin.settings._field', ['key' => 'value[open]', 'label' => 'Jam Buka', 'value' => data_get($value, 'open'), 'type' => 'text', 'placeholder' => '08:00'])
                @include('admin.settings._field', ['key' => 'value[close]', 'label' => 'Jam Tutup', 'value' => data_get($value, 'close'), 'type' => 'text', 'placeholder' => '22:00'])
                @include('admin.settings._field', ['key' => 'value[timezone]', 'label' => 'Timezone', 'value' => data_get($value, 'timezone'), 'type' => 'text', 'placeholder' => 'Asia/Jakarta'])

            {{-- SOCIAL --}}
            @elseif ($section === 'social')
                @include('admin.settings._field', ['key' => 'value[instagram]', 'label' => 'Instagram URL', 'value' => data_get($value, 'instagram'), 'type' => 'url'])
                @include('admin.settings._field', ['key' => 'value[maps]', 'label' => 'Google Maps URL', 'value' => data_get($value, 'maps'), 'type' => 'url'])
                @include('admin.settings._field', ['key' => 'value[contact]', 'label' => 'Email (mailto:)', 'value' => data_get($value, 'contact'), 'type' => 'text'])

            {{-- NAV --}}
            @elseif ($section === 'nav')
                @foreach (data_get($value, 'items', []) as $i => $item)
                    <div class="border border-ink/10 bg-bg p-4">
                        <p class="mb-3 font-mono text-[0.6rem] uppercase tracking-[0.2em] text-olive">Item {{ $i + 1 }}</p>
                        @include('admin.settings._field', ['key' => "value[items][{$i}][label]", 'label' => 'Label', 'value' => $item['label'] ?? '', 'type' => 'text'])
                        @include('admin.settings._field', ['key' => "value[items][{$i}][href]", 'label' => 'Link (href)', 'value' => $item['href'] ?? '', 'type' => 'text'])
                    </div>
                @endforeach

            {{-- HERO --}}
            @elseif ($section === 'hero')
                @include('admin.settings._field', ['key' => 'value[eyebrow]', 'label' => 'Eyebrow', 'value' => data_get($value, 'eyebrow'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[label]', 'label' => 'Label', 'value' => data_get($value, 'label'), 'type' => 'text'])
                <div>
                    <label class="mb-3 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Headline (satu baris per kolom)</label>
                    @foreach (data_get($value, 'lines', ['', '', '', '']) as $i => $line)
                        @include('admin.settings._field', ['key' => "value[lines][{$i}]", 'label' => null, 'value' => $line, 'type' => 'text', 'placeholder' => 'Baris ' . ($i + 1)])
                    @endforeach
                </div>
                @include('admin.settings._field', ['key' => 'value[copy]', 'label' => 'Deskripsi', 'value' => data_get($value, 'copy'), 'type' => 'textarea'])
                @include('admin.settings._field', ['key' => 'value[scroll]', 'label' => 'Scroll CTA', 'value' => data_get($value, 'scroll'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[image][src]', 'label' => 'Gambar (path)', 'value' => data_get($value, 'image.src'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[image][alt]', 'label' => 'Alt teks', 'value' => data_get($value, 'image.alt'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[mono]', 'label' => 'Mono text', 'value' => data_get($value, 'mono'), 'type' => 'text'])

            {{-- MANIFESTO --}}
            @elseif ($section === 'manifesto')
                @include('admin.settings._field', ['key' => 'value[index]', 'label' => 'Nomor Index', 'value' => data_get($value, 'index'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[label]', 'label' => 'Label (ID)', 'value' => data_get($value, 'label'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[en]', 'label' => 'Label (EN)', 'value' => data_get($value, 'en'), 'type' => 'text'])
                <div>
                    <label class="mb-3 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Judul (satu baris per kolom)</label>
                    @foreach (data_get($value, 'title', ['', '', '']) as $i => $line)
                        @include('admin.settings._field', ['key' => "value[title][{$i}]", 'label' => null, 'value' => $line, 'type' => 'text'])
                    @endforeach
                </div>
                @include('admin.settings._field', ['key' => 'value[copy]', 'label' => 'Deskripsi', 'value' => data_get($value, 'copy'), 'type' => 'textarea'])
                @include('admin.settings._field', ['key' => 'value[accent][id]', 'label' => 'Accent (ID)', 'value' => data_get($value, 'accent.id'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[accent][en]', 'label' => 'Accent (EN)', 'value' => data_get($value, 'accent.en'), 'type' => 'text'])

            {{-- SPACE --}}
            @elseif ($section === 'space')
                @include('admin.settings._field', ['key' => 'value[index]', 'label' => 'Nomor Index', 'value' => data_get($value, 'index'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[label]', 'label' => 'Label (ID)', 'value' => data_get($value, 'label'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[en]', 'label' => 'Label (EN)', 'value' => data_get($value, 'en'), 'type' => 'text'])
                <div>
                    <label class="mb-3 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Judul</label>
                    @foreach (data_get($value, 'title', ['', '', '']) as $i => $line)
                        @include('admin.settings._field', ['key' => "value[title][{$i}]", 'label' => null, 'value' => $line, 'type' => 'text'])
                    @endforeach
                </div>
                @include('admin.settings._field', ['key' => 'value[copy]', 'label' => 'Deskripsi', 'value' => data_get($value, 'copy'), 'type' => 'textarea'])
                <div class="border-t border-ink/10 pt-6">
                    <p class="mb-4 font-mono text-[0.6rem] uppercase tracking-[0.2em] text-olive">Gallery Items</p>
                    @foreach (data_get($value, 'items', []) as $i => $item)
                        <div class="mb-4 border border-ink/10 bg-bg p-4">
                            <p class="mb-2 font-mono text-[0.6rem] uppercase tracking-[0.2em] text-olive">Item {{ $i + 1 }}</p>
                            @include('admin.settings._field', ['key' => "value[items][{$i}][n]", 'label' => 'Nomor', 'value' => $item['n'] ?? '', 'type' => 'text'])
                            @include('admin.settings._field', ['key' => "value[items][{$i}][caption]", 'label' => 'Caption (ID)', 'value' => $item['caption'] ?? '', 'type' => 'text'])
                            @include('admin.settings._field', ['key' => "value[items][{$i}][en]", 'label' => 'Caption (EN)', 'value' => $item['en'] ?? '', 'type' => 'text'])
                            @include('admin.settings._field', ['key' => "value[items][{$i}][src]", 'label' => 'Gambar (path)', 'value' => $item['src'] ?? '', 'type' => 'text'])
                            @include('admin.settings._field', ['key' => "value[items][{$i}][alt]", 'label' => 'Alt teks', 'value' => $item['alt'] ?? '', 'type' => 'text'])
                        </div>
                    @endforeach
                </div>

            {{-- COFFEE (heading only) --}}
            @elseif ($section === 'coffee')
                @include('admin.settings._field', ['key' => 'value[index]', 'label' => 'Nomor Index', 'value' => data_get($value, 'index'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[label]', 'label' => 'Label (ID)', 'value' => data_get($value, 'label'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[en]', 'label' => 'Label (EN)', 'value' => data_get($value, 'en'), 'type' => 'text'])
                <div>
                    <label class="mb-3 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Judul</label>
                    @foreach (data_get($value, 'title', ['', '', '']) as $i => $line)
                        @include('admin.settings._field', ['key' => "value[title][{$i}]", 'label' => null, 'value' => $line, 'type' => 'text'])
                    @endforeach
                </div>
                @include('admin.settings._field', ['key' => 'value[copy]', 'label' => 'Deskripsi', 'value' => data_get($value, 'copy'), 'type' => 'textarea'])
                @include('admin.settings._field', ['key' => 'value[image][src]', 'label' => 'Gambar sidebar (path)', 'value' => data_get($value, 'image.src'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[image][alt]', 'label' => 'Alt teks', 'value' => data_get($value, 'image.alt'), 'type' => 'text'])

            {{-- COFFEE PHILOSOPHY --}}
            @elseif ($section === 'coffee_philosophy')
                @include('admin.settings._field', ['key' => 'value[quote]', 'label' => 'Quote', 'value' => data_get($value, 'quote'), 'type' => 'textarea'])
                @include('admin.settings._field', ['key' => 'value[sub]', 'label' => 'Sub text', 'value' => data_get($value, 'sub'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[mono]', 'label' => 'Mono text', 'value' => data_get($value, 'mono'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[image][src]', 'label' => 'Gambar (path)', 'value' => data_get($value, 'image.src'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[image][alt]', 'label' => 'Alt teks', 'value' => data_get($value, 'image.alt'), 'type' => 'text'])

            {{-- BOOKS --}}
            @elseif ($section === 'books')
                @include('admin.settings._field', ['key' => 'value[index]', 'label' => 'Nomor Index', 'value' => data_get($value, 'index'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[label]', 'label' => 'Label (ID)', 'value' => data_get($value, 'label'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[en]', 'label' => 'Label (EN)', 'value' => data_get($value, 'en'), 'type' => 'text'])
                <div>
                    <label class="mb-3 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Judul</label>
                    @foreach (data_get($value, 'title', ['', '']) as $i => $line)
                        @include('admin.settings._field', ['key' => "value[title][{$i}]", 'label' => null, 'value' => $line, 'type' => 'text'])
                    @endforeach
                </div>
                @include('admin.settings._field', ['key' => 'value[copy]', 'label' => 'Deskripsi', 'value' => data_get($value, 'copy'), 'type' => 'textarea'])
                @include('admin.settings._field', ['key' => 'value[image][src]', 'label' => 'Gambar (path)', 'value' => data_get($value, 'image.src'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[image][alt]', 'label' => 'Alt teks', 'value' => data_get($value, 'image.alt'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[marquee]', 'label' => 'Marquee Words (koma per item)', 'value' => implode(', ', data_get($value, 'marquee', [])), 'type' => 'text', 'hint' => 'Pisahkan dengan koma: ARSITEKTUR, DESAIN, FOTOGRAFI'])

            {{-- COMMUNITY --}}
            @elseif ($section === 'community')
                @include('admin.settings._field', ['key' => 'value[index]', 'label' => 'Nomor Index', 'value' => data_get($value, 'index'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[label]', 'label' => 'Label (ID)', 'value' => data_get($value, 'label'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[en]', 'label' => 'Label (EN)', 'value' => data_get($value, 'en'), 'type' => 'text'])
                <div>
                    <label class="mb-3 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Judul</label>
                    @foreach (data_get($value, 'title', ['', '', '']) as $i => $line)
                        @include('admin.settings._field', ['key' => "value[title][{$i}]", 'label' => null, 'value' => $line, 'type' => 'text'])
                    @endforeach
                </div>
                @include('admin.settings._field', ['key' => 'value[copy]', 'label' => 'Deskripsi', 'value' => data_get($value, 'copy'), 'type' => 'textarea'])
                @include('admin.settings._field', ['key' => 'value[image][src]', 'label' => 'Gambar (path)', 'value' => data_get($value, 'image.src'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[image][alt]', 'label' => 'Alt teks', 'value' => data_get($value, 'image.alt'), 'type' => 'text'])

            {{-- JOURNAL --}}
            @elseif ($section === 'journal')
                @include('admin.settings._field', ['key' => 'value[index]', 'label' => 'Nomor Index', 'value' => data_get($value, 'index'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[label]', 'label' => 'Label (ID)', 'value' => data_get($value, 'label'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[en]', 'label' => 'Label (EN)', 'value' => data_get($value, 'en'), 'type' => 'text'])
                <div>
                    <label class="mb-3 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Judul</label>
                    @foreach (data_get($value, 'title', ['', '']) as $i => $line)
                        @include('admin.settings._field', ['key' => "value[title][{$i}]", 'label' => null, 'value' => $line, 'type' => 'text'])
                    @endforeach
                </div>

            {{-- QUOTE --}}
            @elseif ($section === 'quote')
                @include('admin.settings._field', ['key' => 'value[en]', 'label' => 'Teks Inggris', 'value' => data_get($value, 'en'), 'type' => 'text'])
                <div class="border-t border-ink/10 pt-6">
                    <p class="mb-4 font-mono text-[0.6rem] uppercase tracking-[0.2em] text-olive">Baris Kutipan</p>
                    @foreach (data_get($value, 'lines', []) as $i => $line)
                        <div class="mb-3 flex gap-3">
                            <div class="flex-1">
                                @include('admin.settings._field', ['key' => "value[lines][{$i}][text]", 'label' => null, 'value' => $line['text'] ?? '', 'type' => 'text', 'placeholder' => 'Baris ' . ($i + 1)])
                            </div>
                            <div class="flex items-center gap-2 pt-2">
                                <input type="hidden" name="value[lines][{{ $i }}][italic]" value="0">
                                <input type="checkbox" name="value[lines][{{ $i }}][italic]" value="1" class="accent-wood" @checked(data_get($line, 'italic', false))>
                                <label class="font-mono text-[0.6rem] uppercase tracking-[0.2em] text-olive">Italic</label>
                            </div>
                        </div>
                    @endforeach
                </div>

            {{-- VISIT --}}
            @elseif ($section === 'visit')
                @include('admin.settings._field', ['key' => 'value[index]', 'label' => 'Nomor Index', 'value' => data_get($value, 'index'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[label]', 'label' => 'Label (ID)', 'value' => data_get($value, 'label'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[en]', 'label' => 'Label (EN)', 'value' => data_get($value, 'en'), 'type' => 'text'])
                <div>
                    <label class="mb-3 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Judul</label>
                    @foreach (data_get($value, 'title', ['', '']) as $i => $line)
                        @include('admin.settings._field', ['key' => "value[title][{$i}]", 'label' => null, 'value' => $line, 'type' => 'text'])
                    @endforeach
                </div>
                @include('admin.settings._field', ['key' => 'value[copy]', 'label' => 'Deskripsi', 'value' => data_get($value, 'copy'), 'type' => 'textarea'])
                @include('admin.settings._field', ['key' => 'value[hours_label]', 'label' => 'Label Jam', 'value' => data_get($value, 'hours_label'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[cta]', 'label' => 'CTA Button', 'value' => data_get($value, 'cta'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[transport]', 'label' => 'Transport Note', 'value' => data_get($value, 'transport'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[image][src]', 'label' => 'Gambar (path)', 'value' => data_get($value, 'image.src'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[image][alt]', 'label' => 'Alt teks', 'value' => data_get($value, 'image.alt'), 'type' => 'text'])

            {{-- ABOUT --}}
            @elseif ($section === 'about')
                @include('admin.settings._field', ['key' => 'value[index]', 'label' => 'Nomor Index', 'value' => data_get($value, 'index'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[label]', 'label' => 'Label (ID)', 'value' => data_get($value, 'label'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[en]', 'label' => 'Label (EN)', 'value' => data_get($value, 'en'), 'type' => 'text'])
                <div>
                    <label class="mb-3 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Judul</label>
                    @foreach (data_get($value, 'title', ['', '', '']) as $i => $line)
                        @include('admin.settings._field', ['key' => "value[title][{$i}]", 'label' => null, 'value' => $line, 'type' => 'text'])
                    @endforeach
                </div>
                @include('admin.settings._field', ['key' => 'value[copy]', 'label' => 'Deskripsi', 'value' => data_get($value, 'copy'), 'type' => 'textarea'])
                <div class="border-t border-ink/10 pt-6">
                    <p class="mb-4 font-mono text-[0.6rem] uppercase tracking-[0.2em] text-olive">Cerita</p>
                    @include('admin.settings._field', ['key' => 'value[story][label]', 'label' => 'Label Cerita', 'value' => data_get($value, 'story.label'), 'type' => 'text'])
                    @include('admin.settings._field', ['key' => 'value[story][copy]', 'label' => 'Isi Cerita', 'value' => data_get($value, 'story.copy'), 'type' => 'textarea'])
                    @foreach (data_get($value, 'story.points', []) as $i => $point)
                        @include('admin.settings._field', ['key' => "value[story][points][{$i}]", 'label' => 'Point ' . ($i + 1), 'value' => $point, 'type' => 'text'])
                    @endforeach
                </div>
                <div class="border-t border-ink/10 pt-6">
                    <p class="mb-4 font-mono text-[0.6rem] uppercase tracking-[0.2em] text-olive">Nilai-Nilai</p>
                    @foreach (data_get($value, 'values', []) as $i => $val)
                        <div class="mb-4 border border-ink/10 bg-bg p-4">
                            <p class="mb-2 font-mono text-[0.6rem] uppercase tracking-[0.2em] text-olive">Nilai {{ $i + 1 }}</p>
                            @include('admin.settings._field', ['key' => "value[values][{$i}][n]", 'label' => 'Nomor', 'value' => $val['n'] ?? '', 'type' => 'text'])
                            @include('admin.settings._field', ['key' => "value[values][{$i}][name]", 'label' => 'Nama', 'value' => $val['name'] ?? '', 'type' => 'text'])
                            @include('admin.settings._field', ['key' => "value[values][{$i}][copy]", 'label' => 'Deskripsi', 'value' => $val['copy'] ?? '', 'type' => 'textarea'])
                        </div>
                    @endforeach
                </div>
                @include('admin.settings._field', ['key' => 'value[image][src]', 'label' => 'Gambar (path)', 'value' => data_get($value, 'image.src'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[image][alt]', 'label' => 'Alt teks', 'value' => data_get($value, 'image.alt'), 'type' => 'text'])

            {{-- CONTACT --}}
            @elseif ($section === 'contact')
                @include('admin.settings._field', ['key' => 'value[index]', 'label' => 'Nomor Index', 'value' => data_get($value, 'index'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[label]', 'label' => 'Label (ID)', 'value' => data_get($value, 'label'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[en]', 'label' => 'Label (EN)', 'value' => data_get($value, 'en'), 'type' => 'text'])
                <div>
                    <label class="mb-3 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Judul</label>
                    @foreach (data_get($value, 'title', ['', '']) as $i => $line)
                        @include('admin.settings._field', ['key' => "value[title][{$i}]", 'label' => null, 'value' => $line, 'type' => 'text'])
                    @endforeach
                </div>
                @include('admin.settings._field', ['key' => 'value[copy]', 'label' => 'Deskripsi', 'value' => data_get($value, 'copy'), 'type' => 'textarea'])
                <div class="border-t border-ink/10 pt-6">
                    <p class="mb-4 font-mono text-[0.6rem] uppercase tracking-[0.2em] text-olive">Item Kontak</p>
                    @foreach (data_get($value, 'items', []) as $i => $item)
                        <div class="mb-4 border border-ink/10 bg-bg p-4">
                            <p class="mb-2 font-mono text-[0.6rem] uppercase tracking-[0.2em] text-olive">Item {{ $i + 1 }}</p>
                            @include('admin.settings._field', ['key' => "value[items][{$i}][label]", 'label' => 'Label', 'value' => $item['label'] ?? '', 'type' => 'text'])
                            @include('admin.settings._field', ['key' => "value[items][{$i}][value]", 'label' => 'Nilai', 'value' => $item['value'] ?? '', 'type' => 'text'])
                            @include('admin.settings._field', ['key' => "value[items][{$i}][href]", 'label' => 'Link', 'value' => $item['href'] ?? '', 'type' => 'text'])
                        </div>
                    @endforeach
                </div>
                @include('admin.settings._field', ['key' => 'value[note]', 'label' => 'Catatan', 'value' => data_get($value, 'note'), 'type' => 'text'])

            {{-- FOOTER --}}
            @elseif ($section === 'footer')
                @include('admin.settings._field', ['key' => 'value[tagline]', 'label' => 'Tagline', 'value' => data_get($value, 'tagline'), 'type' => 'text'])
                <div class="border-t border-ink/10 pt-6">
                    <p class="mb-4 font-mono text-[0.6rem] uppercase tracking-[0.2em] text-olive">Link Eksternal</p>
                    @foreach (data_get($value, 'links', []) as $i => $link)
                        <div class="mb-3 flex gap-3">
                            <div class="flex-1">
                                @include('admin.settings._field', ['key' => "value[links][{$i}][label]", 'label' => null, 'value' => $link['label'] ?? '', 'type' => 'text', 'placeholder' => 'Label'])
                            </div>
                            <div class="flex-1">
                                @include('admin.settings._field', ['key' => "value[links][{$i}][href]", 'label' => null, 'value' => $link['href'] ?? '', 'type' => 'text', 'placeholder' => 'URL'])
                            </div>
                        </div>
                    @endforeach
                </div>

            {{-- STATUS --}}
            @elseif ($section === 'status')
                @include('admin.settings._field', ['key' => 'value[open_now]', 'label' => 'Teks "Buka"', 'value' => data_get($value, 'open_now'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[closed]', 'label' => 'Teks "Tutup"', 'value' => data_get($value, 'closed'), 'type' => 'text'])
                @include('admin.settings._field', ['key' => 'value[opens_at]', 'label' => 'Teks "Buka Jam..."', 'value' => data_get($value, 'opens_at'), 'type' => 'text'])
            @endif

            <div class="border-t border-ink/10 pt-6">
                <button type="submit" class="link-line inline-flex w-fit items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]">
                    Simpan pengaturan <span aria-hidden="true">→</span>
                </button>
            </div>
        </div>
    </form>
@endsection
