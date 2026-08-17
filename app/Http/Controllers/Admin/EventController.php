<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $query = Event::query();

        if ($search = $request->input('q')) {
            $escaped = str_replace(['%', '_'], ['\\%', '\\_'], $search);
            $query->whereRaw('name LIKE ? ESCAPE ?', ["%{$escaped}%", '\\']);
        }

        return view('admin.events.index', [
            'events' => $query->orderBy('sort_order')->paginate(15)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.events.form', ['event' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $event = Event::create($this->validated($request));

        activity()->performedOn($event)->event('created')->log('Acara "'.$event->name.'" ditambahkan');

        return redirect()->route('admin.events.index')->with('ok', 'Acara ditambahkan.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.form', ['event' => $event]);
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $event->update($this->validated($request));

        activity()->performedOn($event)->event('updated')->log('Acara "'.$event->name.'" diperbarui');

        return redirect()->route('admin.events.index')->with('ok', 'Acara diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $name = $event->name;
        $event->delete();

        activity()->event('deleted')->withProperties(['event_name' => $name])->log('Acara "'.$name.'" dihapus');

        return redirect()->route('admin.events.index')->with('ok', 'Acara dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:300'],
            'status' => ['required', 'string', 'max:60'],
            'event_date' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        return $data;
    }
}
