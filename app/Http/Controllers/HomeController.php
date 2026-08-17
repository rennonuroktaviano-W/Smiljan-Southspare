<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Event;
use App\Models\MenuItem;

class HomeController extends Controller
{
    public function __invoke(): \Illuminate\Contracts\View\View
    {
        return view('home', [
            'articles' => Article::published()->orderBy('date', 'desc')->orderBy('sort_order')->get(),
            'events' => Event::orderBy('sort_order')->get(),
            'menuGroups' => $this->menuGroups(),
        ]);
    }

    private function menuGroups(): \Illuminate\Support\Collection
    {
        $items = MenuItem::published()->orderBy('sort_order')->get();

        return $items->groupBy('category')->map(function ($group) {
            return [
                'name' => $group->first()->category,
                'note' => $group->first()->category_note,
                'is_coffee' => (bool) $group->first()->is_coffee,
                'items' => $group->map(fn ($item) => [
                    'name' => $item->name,
                    'desc' => $item->description,
                    'price' => $item->price,
                ])->values(),
            ];
        })->values();
    }
}
