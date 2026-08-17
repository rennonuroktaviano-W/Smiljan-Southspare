<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/jurnal', [JournalController::class, 'index'])->name('journal.index');
Route::get('/jurnal/{slug}', [JournalController::class, 'show'])->name('journal.show');

Route::get('/menu', MenuController::class)->name('menu');
Route::get('/tentang', fn () => view('about'))->name('about');

Route::get('/kontak', ContactController::class)->name('contact');
Route::post('/kontak', [ContactController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('contact.store');

Route::get('/sitemap.xml', function () {
    return response()
        ->view('sitemap', ['articles' => \App\Models\Article::published()->orderBy('date')->get()])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'authenticate'])
            ->middleware('throttle:5,1')
            ->name('authenticate');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', DashboardController::class)->name('dashboard');

        Route::resource('articles', ArticleController::class)->except(['show']);
        Route::resource('menu', MenuItemController::class)->parameters(['menu' => 'menuItem'])->except(['show']);
        Route::resource('events', EventController::class)->except(['show']);

        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
        Route::post('messages/{message}/read', [MessageController::class, 'read'])->name('messages.read');
        Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });
});
