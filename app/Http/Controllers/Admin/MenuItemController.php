<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(Request $request): View
    {
        $query = MenuItem::query();

        if ($search = $request->input('q')) {
            $escaped = str_replace(['%', '_'], ['\\%', '\\_'], $search);
            $query->where(function (Builder $q) use ($escaped) {
                $q->whereRaw('name LIKE ? ESCAPE ?', ["%{$escaped}%", '\\'])
                    ->orWhereRaw('category LIKE ? ESCAPE ?', ["%{$escaped}%", '\\']);
            });
        }

        if ($request->filled('type')) {
            $query->where('is_coffee', $request->input('type') === 'coffee');
        }

        return view('admin.menu.index', [
            'items' => $query->orderBy('sort_order')->paginate(15)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.menu.form', ['item' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $item = MenuItem::create($this->validated($request));

        activity()->performedOn($item)->event('created')->log('Menu "'.$item->name.'" ditambahkan');

        return redirect()->route('admin.menu.index')->with('ok', 'Menu ditambahkan.');
    }

    public function edit(MenuItem $menuItem): View
    {
        return view('admin.menu.form', ['item' => $menuItem]);
    }

    public function update(Request $request, MenuItem $menuItem): RedirectResponse
    {
        $menuItem->update($this->validated($request));

        activity()->performedOn($menuItem)->event('updated')->log('Menu "'.$menuItem->name.'" diperbarui');

        return redirect()->route('admin.menu.index')->with('ok', 'Menu diperbarui.');
    }

    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        $name = $menuItem->name;
        $menuItem->delete();

        activity()->event('deleted')->withProperties(['menu_name' => $name])->log('Menu "'.$name.'" dihapus');

        return redirect()->route('admin.menu.index')->with('ok', 'Menu dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'category' => ['required', 'string', 'max:60'],
            'category_note' => ['nullable', 'string', 'max:120'],
            'name' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:300'],
            'price' => ['required', 'integer', 'min:0'],
            'is_coffee' => ['nullable', 'boolean'],
            'published' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_coffee'] = $request->boolean('is_coffee');
        $data['published'] = $request->boolean('published');

        return $data;
    }
}
