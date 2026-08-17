@props([
    'key',
    'label' => null,
    'value' => '',
    'type' => 'text',
    'placeholder' => '',
    'hint' => '',
])

<div>
    @if ($label)
        <label for="{{ str_replace(['[', ']'], ['_', ''], $key) }}" class="mb-2 block font-mono text-[0.6rem] uppercase tracking-[0.24em] text-olive">{{ $label }}</label>
    @endif

    @if ($type === 'textarea')
        <textarea
            id="{{ str_replace(['[', ']'], ['_', ''], $key) }}"
            name="{{ $key }}"
            rows="4"
            {{ $attributes->merge(['class' => 'w-full resize-y border-b border-ink/15 bg-transparent pb-2 text-[0.9rem] leading-snug focus:border-wood focus:outline-none']) }}
        >{{ $value }}</textarea>
    @else
        <input
            id="{{ str_replace(['[', ']'], ['_', ''], $key) }}"
            name="{{ $key }}"
            type="{{ $type }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'w-full border-b border-ink/15 bg-transparent pb-2 text-[0.9rem] focus:border-wood focus:outline-none']) }}
        >
    @endif

    @if ($hint)
        <p class="mt-1 font-mono text-[0.58rem] uppercase tracking-[0.18em] text-olive">{{ $hint }}</p>
    @endif
</div>
