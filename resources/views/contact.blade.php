@extends('layouts.page')

@section('title', 'Kontak — SMILJAN SOUTHSPARE')
@section('meta-description', 'Hubungi Smiljan Southspare — email, Instagram, atau temui kami di Jl. BDN 1, Cilandak Barat, Jakarta Selatan. Buka setiap hari 08:00—22:00.')

@section('content')
    <section class="pt-32 lg:pt-44">
        <div class="wrap">
            <div class="flex items-baseline justify-between font-mono text-[0.62rem] uppercase tracking-[0.26em]">
                <span class="text-olive" data-reveal>{{ config('site.contact.index') }} / {{ config('site.contact.label') }}</span>
                <span class="hidden sm:inline" data-reveal>{{ config('site.contact.en') }}</span>
            </div>

            <div class="mt-14 grid gap-8 lg:mt-20 lg:grid-cols-12 lg:items-end">
                <h1 class="font-display text-[clamp(2.6rem,9vw,7.5rem)] leading-[0.9] tracking-[-0.01em] lg:col-span-8">
                    @foreach (config('site.contact.title') as $index => $line)
                        <span class="hero-line block whitespace-nowrap" style="--d: {{ 0.08 + $index * 0.11 }}s">{{ $line }}</span>
                    @endforeach
                </h1>
                <p class="max-w-sm text-[1.02rem] leading-relaxed text-ink/75 lg:col-span-4" data-reveal style="--d: 0.4s">
                    {{ config('site.contact.copy') }}
                </p>
            </div>
        </div>
    </section>

    <section class="pb-28 lg:pb-44">
        <div class="wrap">
            <div class="mt-16 grid gap-14 border-t pt-14 hairline lg:mt-24 lg:grid-cols-12">
                <div class="lg:col-span-6">
                    <div class="flex flex-col">
                        @foreach (config('site.contact.items') as $item)
                            <a href="{{ $item['href'] }}" target="_blank" rel="noopener" class="group flex items-baseline gap-6 border-b border-ink/10 py-5 transition-colors duration-500 hover:bg-bg/40" data-reveal>
                                <span class="w-24 flex-none font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">{{ $item['label'] }}</span>
                                <span class="font-display text-[clamp(1.3rem,3vw,2.2rem)] leading-none transition-colors duration-500 group-hover:text-wood">
                                    {{ $item['value'] }}
                                </span>
                                <span class="ml-auto font-mono text-[0.8rem] text-wood transition-transform duration-500 group-hover:translate-x-1" aria-hidden="true">↗</span>
                            </a>
                        @endforeach
                    </div>

                    <p class="mt-6 font-mono text-[0.58rem] uppercase tracking-[0.22em] text-olive" data-reveal>
                        {{ config('site.contact.note') }}
                    </p>
                </div>

                <div class="lg:col-span-5 lg:col-start-8">
                    <form method="POST" action="{{ route('contact.store') }}" class="border-t pt-6 hairline" data-reveal>
                        @csrf

                        <p class="font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">Tinggalkan pesan</p>

                        @if (session('sent'))
                            <div class="mt-5 border border-wood/40 bg-wood/5 p-4 text-[0.9rem] leading-relaxed text-coffee">
                                Terima kasih, pesanmu sudah sampai. Kami balas pelan-pelan — dalam 1—2 hari.
                            </div>
                        @endif

                        <div class="mt-6 flex flex-col gap-6">
                            <div>
                                <label for="name" class="sr-only">Nama</label>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name') }}"
                                    placeholder="Nama"
                                    required
                                    autocomplete="name"
                                    class="w-full border-b border-ink/15 bg-transparent pb-2 font-display text-[1.4rem] leading-none placeholder:text-ink/35 focus:border-wood focus:outline-none"
                                >
                                @error('name')
                                    <p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="sr-only">Email</label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    placeholder="Email"
                                    required
                                    autocomplete="email"
                                    class="w-full border-b border-ink/15 bg-transparent pb-2 font-display text-[1.4rem] leading-none placeholder:text-ink/35 focus:border-wood focus:outline-none"
                                >
                                @error('email')
                                    <p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="message" class="sr-only">Pesan</label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="4"
                                    placeholder="Pesan"
                                    required
                                    class="w-full resize-none border-b border-ink/15 bg-transparent pb-2 font-display text-[1.2rem] leading-snug placeholder:text-ink/35 focus:border-wood focus:outline-none"
                                >{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-2 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="link-line inline-flex w-fit items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]" data-magnetic>
                                Kirim pesan <span aria-hidden="true">→</span>
                            </button>
                        </div>
                    </form>

                    <div class="mt-12 border-t pt-6 hairline" data-reveal>
                        <p class="font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">{{ config('site.visit.hours_label') }}</p>
                        <p class="mt-3 font-display text-[2.1rem] leading-none">
                            {{ config('site.hours.open') }} — {{ config('site.hours.close') }}
                        </p>
                    </div>

                    <address class="mt-8 not-italic" data-reveal>
                        <p class="font-display text-[1.35rem] leading-snug">{{ config('site.brand.name') }} {{ config('site.brand.sub') }}</p>
                        @foreach (config('site.address.lines') as $line)
                            <p class="text-[0.95rem] leading-relaxed text-ink/75">{{ $line }}</p>
                        @endforeach
                    </address>

                    <div class="mt-10" data-reveal>
                        <a href="{{ config('site.address.maps_url') }}" target="_blank" rel="noopener" class="link-line inline-flex w-fit items-center gap-3 font-mono text-[0.75rem] uppercase tracking-[0.26em]" data-magnetic>
                            {{ config('site.visit.cta') }} <span aria-hidden="true">↗</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
