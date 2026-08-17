<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Contracts\View\View;

class MenuController extends Controller
{
    public function __invoke(): View
    {
        $items = MenuItem::published()->orderBy('sort_order')->get();

        $groups = $items->groupBy('category')->map(function ($group) {
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

        return view('menu', ['groups' => $groups]);
    }
}
