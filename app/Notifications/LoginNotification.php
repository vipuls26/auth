<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function ViaQueues()
    {
        return [
            'mail' => 'high',
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Login Alert')
            ->greeting('Hello ' . $notifiable->name)
            ->line('You just logged into your account.')
            ->line('If this was not you, please reset your password.');
    }


}
