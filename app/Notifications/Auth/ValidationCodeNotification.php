<?php declare(strict_types = 1);

namespace App\Notifications\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ValidationCodeNotification extends Notification
{
    use Queueable;

    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage())
                    ->line('Your validation code is: ' . $notifiable->validation_code);
    }
}
