<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    public function index(): View
    {
        return view('admin.messages.index', [
            'messages' => Message::latest()->get(),
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
