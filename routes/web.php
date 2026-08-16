<?php

use App\Http\Controllers\JournalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/jurnal', [JournalController::class, 'index'])->name('journal.index');
Route::get('/jurnal/{slug}', [JournalController::class, 'show'])->name('journal.show');

Route::get('/menu', fn () => view('menu'))->name('menu');
Route::get('/tentang', fn () => view('about'))->name('about');
Route::get('/kontak', fn () => view('contact'))->name('contact');
