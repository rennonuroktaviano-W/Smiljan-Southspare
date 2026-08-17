<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = Message::query();

        if ($request->filled('filter')) {
            $query->where('is_read', $request->input('filter') === 'read');
        }

        if ($search = $request->input('q')) {
            $escaped = str_replace(['%', '_'], ['\\%', '\\_'], $search);
            $query->where(function (Builder $q) use ($escaped) {
                $q->whereRaw('name LIKE ? ESCAPE ?', ["%{$escaped}%", '\\'])
                    ->orWhereRaw('email LIKE ? ESCAPE ?', ["%{$escaped}%", '\\'])
                    ->orWhereRaw('message LIKE ? ESCAPE ?', ["%{$escaped}%", '\\']);
            });
        }

        return view('admin.messages.index', [
            'messages' => $query->latest()->paginate(15)->withQueryString(),
        ]);
    }

    public function read(Message $message): RedirectResponse
    {
        $message->update(['is_read' => true]);
        Cache::forget('unread_messages');

        activity()->performedOn($message)->event('message_read')->log('Pesan dari "'.$message->name.'" ditandai sudah dibaca');

        return back()->with('ok', 'Pesan ditandai sudah dibaca.');
    }

    public function destroy(Message $message): RedirectResponse
    {
        $name = $message->name;
        $message->delete();
        Cache::forget('unread_messages');

        activity()->event('message_deleted')->withProperties(['sender' => $name])->log('Pesan dari "'.$name.'" dihapus');

        return back()->with('ok', 'Pesan dihapus.');
    }
}
