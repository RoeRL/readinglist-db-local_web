<?php

namespace Database\Seeders;

use App\Models\Manga;
use Illuminate\Database\Seeder;

class MangaSeeder extends Seeder
{
    public function run(): void
    {
        $entries = [
            [
                'title'           => 'Test1',
                'description'     => 'A dark fantasy epic story type shii',
                'cover_url'       => 'https://tenor.com/search/cats-flying-jets-gifs',
                'status'          => 'reading',
                'current_chapter' => 10,
                'total_chapters'  => 15,
                'genres'          => ['Dark Fantasy', 'Action', 'Adventure'],
                'sources'         => [
                    ['label' => 'MangaDex', 'url' => 'https://mangadex.org/title/801513ba-a712-498c-8f57-cae55b38cc92'],
                ],
            ],
            [
                'title'           => 'Test2',
                'description'     => 'A dark fantasy epic story type shii 2',
                'cover_url'       => 'https://tenor.com/search/cats-flying-jets-gifs',
                'status'          => 'reading',
                'current_chapter' => 10,
                'total_chapters'  => 15,
                'genres'          => ['Fantasy', 'Action', 'Adventure'],
                'sources'         => [
                    ['label' => 'MangaDex', 'url' => 'https://mangadex.org/title/801513ba-a712-498c-8f57-cae55b38cc92'],
                ],
            ],
        ];

        foreach ($entries as $entry) {
            Manga::create($entry);
        }
    }
}
