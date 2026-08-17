<?php

namespace App\Providers;

use App\Models\Message;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Vite::useCspNonce();

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->input('email').'|'.$request->ip()
            );
        });

        RateLimiter::for('admin', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('two_factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(120)->by($request->ip());
        });

        view()->composer('admin.layouts.admin', function ($view) {
            $unread = Cache::remember('unread_messages', 60, fn () => Message::where('is_read', false)->count());

            $view->with('adminNav', [
                ['label' => 'Dashboard', 'href' => route('admin.dashboard'), 'active' => 'admin.dashboard'],
                ['label' => 'Artikel', 'href' => route('admin.articles.index'), 'active' => 'admin.articles.*'],
                ['label' => 'Menu', 'href' => route('admin.menu.index'), 'active' => 'admin.menu.*'],
                ['label' => 'Acara', 'href' => route('admin.events.index'), 'active' => 'admin.events.*'],
                ['label' => 'Pesan', 'href' => route('admin.messages.index'), 'active' => 'admin.messages.*', 'badge' => $unread ?: null],
                ['label' => 'Aktivitas', 'href' => route('admin.activity.index'), 'active' => 'admin.activity.*'],
                ['label' => 'Pengaturan', 'href' => route('admin.settings.index'), 'active' => 'admin.settings.*'],
                ['label' => 'Profil', 'href' => route('admin.profile.edit'), 'active' => 'admin.profile.*'],
            ]);
        });
    }
}
