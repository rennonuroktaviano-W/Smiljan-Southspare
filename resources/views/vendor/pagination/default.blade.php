@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-2" aria-label="Navigasi halaman">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 font-mono text-[0.7rem] text-ink/30">← Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 font-mono text-[0.7rem] text-olive transition-colors hover:bg-ink/5 hover:text-ink">
                ← Prev
            </a>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-2 py-1.5 font-mono text-[0.7rem] text-ink/30">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1.5 font-mono text-[0.7rem] bg-ink text-paper">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 font-mono text-[0.7rem] text-olive transition-colors hover:bg-ink/5 hover:text-ink">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 font-mono text-[0.7rem] text-olive transition-colors hover:bg-ink/5 hover:text-ink">
                Next →
            </a>
        @else
            <span class="px-3 py-1.5 font-mono text-[0.7rem] text-ink/30">Next →</span>
        @endif
    </nav>
@endif
