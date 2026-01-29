<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderPlaced extends Notification
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $o = $this->order->loadMissing('items.perfume');

        return (new MailMessage)
            ->subject("Order #{$o->id} Confirmed - Essantra")
            ->greeting("Hi {$notifiable->name},")
            ->line("Thanks for your order! We received your order #{$o->id}.")
            ->line("Payment method: " . strtoupper($o->payment_method))
            ->line("Current status: " . ucfirst($o->status))
            ->line("Total: LKR " . number_format($o->total, 2))
            ->action('View My Orders', route('orders.my'))
            ->line('Thank you for shopping with Essantra!');
    }
}
