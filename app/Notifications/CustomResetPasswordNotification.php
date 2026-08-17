<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends ResetPassword implements ShouldQueue
{
    use Queueable;

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reset Kata Sandi — '.config('app.name'))
            ->greeting('Halo,')
            ->line('Kami menerima permintaan untuk mereset kata sandi akun admin Anda.')
            ->action('Reset Kata Sandi', $this->resetUrl($notifiable))
            ->line('Tautan ini akan kedaluwarsa dalam 60 menit.')
            ->line('Jika Anda tidak meminta reset, abaikan email ini.')
            ->salutation(config('app.name'));
    }
}
