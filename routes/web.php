<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MangaController;

Route::get('/', fn() => redirect()->route('manga.index'));
Route::resource('manga', MangaController::class);

