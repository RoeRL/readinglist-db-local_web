@props(['manga'])

<div class="manga-card group relative flex flex-col rounded-shelf overflow-hidden bg-ink-700 border border-ink-500">

    {{-- ── Cover ── --}}
    <a href="{{ route('manga.show', $manga) }}" class="block aspect-[2/3] overflow-hidden">
        @if ($manga->cover_url)
            <img src="{{ $manga->cover_url }}"
                 alt="{{ $manga->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                 loading="lazy"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
            <div class="cover-placeholder w-full h-full hidden">
                <span class="text-ink-300 text-xs font-mono">No Cover</span>
            </div>
        @else
            <div class="cover-placeholder w-full h-full">
                <span class="text-ink-300 text-xs font-mono">No Cover</span>
            </div>
        @endif
    </a>

    {{-- ── Status Badge (overlay) ── --}}
    <div class="absolute top-2 left-2">
        <span class="status-badge text-ink-900"
              style="background-color: {{ $manga->statusColor() }};">
            {{ $manga->statusLabel() }}
        </span>
    </div>

    {{-- ── Info ── --}}
    <div class="p-3 flex flex-col gap-1 flex-1">
        <a href="{{ route('manga.show', $manga) }}"
           class="font-display text-sm leading-snug text-paper hover:text-accent transition-colors line-clamp-2">
            {{ $manga->title }}
        </a>

        {{-- Genres ── --}}
        @if (!empty($manga->genreList()))
            <div class="flex flex-wrap gap-1 mt-0.5">
                @foreach (array_slice($manga->genreList(), 0, 2) as $genre)
                    <span class="text-ink-200 bg-ink-600 text-[0.6rem] font-mono px-1.5 py-0.5 rounded-sm">
                        {{ $genre }}
                    </span>
                @endforeach
                @if (count($manga->genreList()) > 2)
                    <span class="text-ink-300 text-[0.6rem] font-mono">+{{ count($manga->genreList()) - 2 }}</span>
                @endif
            </div>
        @endif

        {{-- Chapter Progress ── --}}
        <div class="mt-auto pt-2">
            <div class="flex justify-between items-center mb-1">
                <span class="text-ink-300 text-[0.65rem] font-mono">{{ $manga->chapterLabel() }}</span>
                @if ($manga->total_chapters)
                    <span class="text-ink-300 text-[0.65rem] font-mono">{{ $manga->progressPercent() }}%</span>
                @endif
            </div>
            @if ($manga->total_chapters)
                <div class="h-0.5 bg-ink-500 rounded-full overflow-hidden">
                    <div class="progress-bar-fill h-full rounded-full"
                         style="width: {{ $manga->progressPercent() }}%; background-color: {{ $manga->statusColor() }};"></div>
                </div>
            @endif
        </div>
    </div>

</div>
