{{--
    Shared form partial.
    Usage:
        @include('manga._form', ['manga' => $manga])       ← edit (model bound)
        @include('manga._form', ['manga' => null])         ← create
--}}

@php
    $isEdit      = isset($manga) && $manga !== null;
    $old         = fn($field, $default = '') => old($field, $isEdit ? ($manga->$field ?? $default) : $default);
    $oldGenres   = old('genres_raw', $isEdit ? implode(', ', $manga->genreList()) : '');
    $oldSources  = old('sources', $isEdit ? ($manga->sources ?? []) : [['label' => '', 'url' => '']]);
@endphp

{{-- ── Title ── --}}
<div class="form-group">
    <label class="form-label">Title <span class="text-red-400">*</span></label>
    <input type="text" name="title" value="{{ $old('title') }}"
           class="form-input" placeholder="e.g. Berserk" required />
    @error('title') <p class="form-error">{{ $message }}</p> @enderror
</div>

{{-- ── Description ── --}}
<div class="form-group">
    <label class="form-label">Description</label>
    <textarea name="description" rows="3"
              class="form-input resize-none"
              placeholder="Short synopsis or personal notes…">{{ $old('description') }}</textarea>
    @error('description') <p class="form-error">{{ $message }}</p> @enderror
</div>

{{-- ── Cover URL ── --}}
<div class="form-group">
    <label class="form-label">Cover Image URL</label>
    <input type="url" name="cover_url" value="{{ $old('cover_url') }}"
           class="form-input" placeholder="https://cdn.example.com/cover.jpg" />
    @error('cover_url') <p class="form-error">{{ $message }}</p> @enderror
</div>

{{-- ── Status ── --}}
<div class="form-group">
    <label class="form-label">Status <span class="text-red-400">*</span></label>
    <select name="status" class="form-input" required>
        @foreach ($statuses as $key => $label)
            <option value="{{ $key }}" {{ $old('status', 'plan-to-read') === $key ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('status') <p class="form-error">{{ $message }}</p> @enderror
</div>

{{-- ── Chapter Progress ── --}}
<div class="grid grid-cols-2 gap-4">
    <div class="form-group">
        <label class="form-label">Current Chapter</label>
        <input type="number" name="current_chapter" value="{{ $old('current_chapter') }}"
               class="form-input" placeholder="0" min="0" />
        @error('current_chapter') <p class="form-error">{{ $message }}</p> @enderror
    </div>
    <div class="form-group">
        <label class="form-label">Total Chapters</label>
        <input type="number" name="total_chapters" value="{{ $old('total_chapters') }}"
               class="form-input" placeholder="Unknown" min="0" />
        @error('total_chapters') <p class="form-error">{{ $message }}</p> @enderror
    </div>
</div>

{{-- ── Genres (free-form) ── --}}
<div class="form-group">
    <label class="form-label">Genres / Tags</label>
    <input type="text" name="genres_raw" value="{{ $oldGenres }}"
           class="form-input"
           placeholder="Action, Fantasy, Isekai, …" />
    <p class="text-ink-400 text-xs font-mono mt-1">Comma-separated, free-form.</p>
    @error('genres_raw') <p class="form-error">{{ $message }}</p> @enderror
</div>

{{-- ── Sources (dynamic rows) ── --}}
<div class="form-group" x-data="sourcesManager({{ json_encode($oldSources) }})">
    <label class="form-label">Sources</label>

    <div class="flex flex-col gap-2" id="sources-list">
        <template x-for="(source, index) in sources" :key="index">
            <div class="source-row flex gap-2 items-start">
                <input type="text"
                       :name="`sources[${index}][label]`"
                       x-model="source.label"
                       class="form-input w-36 flex-shrink-0"
                       placeholder="Label" />
                <input type="url"
                       :name="`sources[${index}][url]`"
                       x-model="source.url"
                       class="form-input flex-1"
                       placeholder="https://…" />
                <button type="button"
                        @click="remove(index)"
                        class="mt-px text-ink-400 hover:text-red-400 transition-colors text-lg leading-none px-1"
                        title="Remove">×</button>
            </div>
        </template>
    </div>

    <button type="button"
            @click="add()"
            class="mt-2 text-xs font-mono text-accent hover:text-paper uppercase tracking-widest transition-colors">
        + Add Source
    </button>

    @error('sources') <p class="form-error">{{ $message }}</p> @enderror
    @error('sources.*.url') <p class="form-error">{{ $message }}</p> @enderror
</div>

{{-- ── Alpine component ── --}}
<script>
    function sourcesManager(initial) {
        return {
            sources: initial && initial.length ? initial : [{ label: '', url: '' }],
            add()   { this.sources.push({ label: '', url: '' }); },
            remove(i) { this.sources.splice(i, 1); if (!this.sources.length) this.add(); },
        };
    }
</script>

{{-- ── Shared form styles ── --}}
<style>
    .form-group { display: flex; flex-direction: column; gap: 0.375rem; }
    .form-label { font-family: 'DM Mono', monospace; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; color: #A1A1AA; }
    .form-input  {
        background: #1C1C1F; border: 1px solid #3F3F46; color: #E4E4E7;
        padding: 0.5rem 0.75rem; font-size: 0.875rem; border-radius: 3px;
        width: 100%; outline: none; font-family: 'DM Sans', sans-serif;
        transition: border-color 0.15s;
    }
    .form-input:focus { border-color: #C8A96E; }
    .form-input::placeholder { color: #52525B; }
    select.form-input option { background: #1C1C1F; }
    .form-error { color: #EF4444; font-size: 0.7rem; font-family: 'DM Mono', monospace; }
</style>
