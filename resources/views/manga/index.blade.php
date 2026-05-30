@extends('layouts.app')

@section('title', 'Manga Shelf')

@section('content')

{{-- ── Page Header ── --}}
<div class="mb-6">
    <h1 class="font-display text-3xl italic text-paper">Library</h1>
    <p class="text-ink-200 text-sm mt-1 font-mono">
        {{ $mangas->count() }} {{ $status === 'all' ? 'total entries' : Manga::$statuses[$status] ?? $status }}
    </p>
</div>

{{-- ── Status Tab Strip ── --}}
<nav class="flex gap-0 border-b border-ink-600 mb-8 overflow-x-auto pb-px">
    @php
        $tabs = ['all' => 'All'] + $statuses;
    @endphp

    @foreach ($tabs as $key => $label)
        @php
            $count = $key === 'all' ? array_sum($counts) : ($counts[$key] ?? 0);
            $isActive = $status === $key;
        @endphp
        <a href="{{ route('manga.index', $key !== 'all' ? ['status' => $key] : []) }}"
           class="whitespace-nowrap px-4 py-2.5 text-xs font-mono uppercase tracking-widest transition-colors duration-150
                  {{ $isActive ? 'tab-active text-accent' : 'text-ink-300 hover:text-paper border-b-2 border-transparent' }}">
            {{ $label }}
            @if ($count > 0)
                <span class="ml-1 text-ink-400">({{ $count }})</span>
            @endif
        </a>
    @endforeach
</nav>

{{-- ── Grid ── --}}
@if ($mangas->isEmpty())
    <div class="flex flex-col items-center justify-center py-24 text-center">
        <div class="text-ink-500 font-display text-5xl italic mb-4">Empty.</div>
        <p class="text-ink-300 text-sm font-mono mb-6">No entries in this category yet.</p>
        <a href="{{ route('manga.create') }}"
           class="text-xs font-mono uppercase tracking-widest px-5 py-2.5 border border-accent text-accent hover:bg-accent hover:text-ink-900 transition-all">
            + Add Entry
        </a>
    </div>
@else
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7 gap-4">
        @foreach ($mangas as $manga)
            <x-manga-card :manga="$manga" />
        @endforeach
    </div>
@endif

@endsection
