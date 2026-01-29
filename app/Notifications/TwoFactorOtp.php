<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TwoFactorOtp extends Notification
{
    use Queueable;

    public function __construct(
        public string $otp,
        public int $minutes = 10
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your verification code')
            ->greeting('Hi ' . ($notifiable->name ?? ''))
            ->line('Use the code below to complete your login:')
            ->line('**' . $this->otp . '**')
            ->line("This code expires in {$this->minutes} minutes.")
            ->line('If you did not try to sign in, please ignore this email.');
    }
}
