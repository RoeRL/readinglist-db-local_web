<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMangaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'                  => ['required', 'string', 'max:255'],
            'description'            => ['nullable', 'string'],
            'cover_url'              => ['nullable', 'url', 'max:2048'],
            'status'                 => ['required', 'in:plan-to-read,reading,on-hold,completed,re-reading,dropped'],
            'current_chapter'        => ['nullable', 'integer', 'min:0'],
            'total_chapters'         => ['nullable', 'integer', 'min:0'],
            'genres_raw'             => ['nullable', 'string'],          // comma-separated free-form
            'sources'                => ['nullable', 'array'],
            'sources.*.label'        => ['nullable', 'string', 'max:100'],
            'sources.*.url'          => ['nullable', 'url', 'max:2048'],
        ];
    }

    /**
     * Prepare the data for validation.
     * Parse genres_raw into a clean array before validation runs.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('genres_raw')) {
            $genres = collect(explode(',', $this->genres_raw))
                ->map(fn($g) => trim($g))
                ->filter()
                ->values()
                ->all();

            $this->merge(['genres' => $genres]);
        }

        // Remove empty source rows (both label and url blank)
        if ($this->has('sources')) {
            $sources = collect($this->sources)
                ->filter(fn($s) => !empty($s['url']))
                ->values()
                ->all();
            $this->merge(['sources' => $sources]);
        }
    }
}
