<?php

namespace App\Http\Controllers;

use App\Http\Traits\HoneypotProtection;
use App\Mail\ContactNotificationMail;
use App\Models\Message;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    use HoneypotProtection;

    public function __invoke(): View
    {
        return view('contact');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($this->honeypotFilled($request)) {
            activity()
                ->withProperties(['ip' => $request->ip()])
                ->event('honeypot')
                ->log('Bot terdeteksi pada form kontak');

            return back()->with('sent', true);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Message::create($validated);

        $adminEmail = config('admin.email', config('mail.from.address'));
        if ($adminEmail) {
            Mail::to($adminEmail)->queue(
                new ContactNotificationMail($validated['name'], $validated['email'], $validated['message'])
            );
        }

        return back()->with('sent', true);
    }
}
