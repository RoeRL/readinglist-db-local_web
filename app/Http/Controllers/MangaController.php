<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Manga::orderBy('updated_at', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $mangas   = $query->get();
        $statuses = Manga::$statuses;
        $counts   = Manga::selectRaw('status, count(*) as total')
                         ->groupBy('status')
                         ->pluck('total', 'status')
                         ->toArray();

        return view('manga.index', compact('mangas', 'status', 'statuses', 'counts'));
    }


}
