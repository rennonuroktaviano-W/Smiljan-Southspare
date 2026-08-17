<?php

namespace App\Providers;

use App\Models\Message;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('admin.layouts.admin', function ($view) {
            $unread = Message::where('is_read', false)->count();

            $view->with('adminNav', [
                ['label' => 'Dashboard', 'href' => route('admin.dashboard'), 'active' => 'admin.dashboard'],
                ['label' => 'Artikel', 'href' => route('admin.articles.index'), 'active' => 'admin.articles.*'],
                ['label' => 'Menu', 'href' => route('admin.menu.index'), 'active' => 'admin.menu.*'],
                ['label' => 'Acara', 'href' => route('admin.events.index'), 'active' => 'admin.events.*'],
                ['label' => 'Pesan', 'href' => route('admin.messages.index'), 'active' => 'admin.messages.*', 'badge' => $unread ?: null],
            ]);
        });
    }
}
