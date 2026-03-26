<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterNotification extends Notification implements ShouldQueue
{

    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function ViaQueues()
    {
        return [
            'mail' => 'medium',
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Account Register')
            ->greeting('Hello ' . $notifiable->name)
            ->line('You have recentlt register your account to our website');
    }
}
