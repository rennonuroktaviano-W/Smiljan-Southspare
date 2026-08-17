<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Event;
use App\Models\MenuItem;
use App\Models\Message;

class DashboardController extends Controller
{
    public function __invoke(): \Illuminate\Contracts\View\View
    {
        return view('admin.dashboard', [
            'articles' => Article::count(),
            'menuItems' => MenuItem::count(),
            'events' => Event::count(),
            'unread' => Message::where('is_read', false)->count(),
            'recentMessages' => Message::latest()->limit(5)->get(),
        ]);
    }
}
