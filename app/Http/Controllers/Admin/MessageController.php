<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = Message::query();

        if ($request->filled('filter')) {
            $query->where('is_read', $request->input('filter') === 'read');
        }

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        return view('admin.messages.index', [
            'messages' => $query->latest()->paginate(15)->withQueryString(),
        ]);
    }

    public function read(Message $message): RedirectResponse
    {
        $message->update(['is_read' => true]);

        return back()->with('ok', 'Pesan ditandai sudah dibaca.');
    }

    public function destroy(Message $message): RedirectResponse
    {
        $message->delete();

        return back()->with('ok', 'Pesan dihapus.');
    }
}
