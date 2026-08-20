<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Middleware\EnsureTwoFactorVerified;
use App\Models\Article;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/jurnal', [JournalController::class, 'index'])->name('journal.index');
Route::get('/jurnal/{slug}', [JournalController::class, 'show'])->name('journal.show');

Route::get('/menu', MenuController::class)->name('menu');
Route::get('/tentang', fn () => view('about'))->name('about');

Route::get('/kontak', ContactController::class)->name('contact');
Route::post('/kontak', [ContactController::class, 'store'])
    ->middleware(['throttle:10,1', 'turnstile'])
    ->name('contact.store');

Route::get('/sitemap.xml', function () {
    return response()
        ->view('sitemap', ['articles' => Article::published()->orderBy('date')->get()])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'authenticate'])
            ->middleware(['throttle:login', 'turnstile'])
            ->name('authenticate');

        Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
        Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
            ->middleware(['throttle:5,1', 'turnstile'])
            ->name('password.email');
        Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
        Route::post('/reset-password', [PasswordResetController::class, 'reset'])
            ->middleware('turnstile')
            ->name('password.update');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/two-factor/challenge', [TwoFactorController::class, 'showChallenge'])
            ->withoutMiddleware([EnsureTwoFactorVerified::class])
            ->name('two-factor.challenge');
        Route::post('/two-factor/verify', [TwoFactorController::class, 'verify'])
            ->middleware(['throttle:two_factor', 'turnstile'])
            ->withoutMiddleware([EnsureTwoFactorVerified::class])
            ->name('two-factor.verify');

        Route::get('/two-factor/setup', [TwoFactorController::class, 'showSetup'])
            ->withoutMiddleware([EnsureTwoFactorVerified::class])
            ->name('two-factor.setup');
        Route::post('/two-factor/enable', [TwoFactorController::class, 'enable'])
            ->middleware('throttle:two_factor')
            ->withoutMiddleware([EnsureTwoFactorVerified::class])
            ->name('two-factor.enable');
        Route::get('/two-factor/recovery', [TwoFactorController::class, 'showRecovery'])
            ->withoutMiddleware([EnsureTwoFactorVerified::class])
            ->name('two-factor.recovery');
        Route::post('/two-factor/recovery/confirm', [TwoFactorController::class, 'confirmRecovery'])
            ->withoutMiddleware([EnsureTwoFactorVerified::class])
            ->name('two-factor.recovery.confirm');

        Route::middleware('two_factor')->group(function () {
            Route::middleware('throttle:admin')->group(function () {
                Route::get('/', DashboardController::class)->name('dashboard');

                Route::resource('articles', ArticleController::class)->except(['show']);
                Route::resource('menu', MenuItemController::class)->parameters(['menu' => 'menuItem'])->except(['show']);
                Route::resource('events', EventController::class)->except(['show']);

                Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
                Route::post('messages/{message}/read', [MessageController::class, 'read'])->name('messages.read');
                Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

                Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
                Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

                Route::post('images/upload', [ImageController::class, 'store'])->name('images.upload');
                Route::delete('images', [ImageController::class, 'destroy'])->name('images.destroy');

                Route::get('activity', [ActivityController::class, 'index'])->name('activity.index');

                Route::get('settings', [SiteSettingController::class, 'index'])->name('settings.index');
                Route::get('settings/{section}/edit', [SiteSettingController::class, 'edit'])->name('settings.edit');
                Route::put('settings/{section}', [SiteSettingController::class, 'update'])->name('settings.update');

                Route::delete('two-factor', [TwoFactorController::class, 'disable'])->name('two-factor.disable');
            });
        });
    });
});
