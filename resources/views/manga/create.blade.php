@extends('layouts.app')

@section('title', 'Add Entry')

@section('content')

<div class="max-w-2xl mx-auto">

    <a href="{{ route('manga.index') }}"
       class="inline-flex items-center gap-2 text-ink-300 hover:text-paper text-xs font-mono uppercase tracking-widest mb-8 transition-colors">
        ← Back to Library
    </a>

    <h1 class="font-display text-3xl italic text-paper mb-8">Add Entry</h1>

    <form method="POST" action="{{ route('manga.store') }}" class="flex flex-col gap-6">
        @csrf

        @include('manga._form', ['manga' => null])

        <div class="flex gap-3 pt-4 border-t border-ink-600">
            <button type="submit"
                    class="text-xs font-mono uppercase tracking-widest px-6 py-2.5 bg-accent text-ink-900 hover:bg-amber-400 transition-colors">
                Save Entry
            </button>
            <a href="{{ route('manga.index') }}"
               class="text-xs font-mono uppercase tracking-widest px-6 py-2.5 border border-ink-500 text-ink-300 hover:text-paper hover:border-ink-300 transition-colors">
                Cancel
            </a>
        </div>
    </form>

</div>

@endsection
