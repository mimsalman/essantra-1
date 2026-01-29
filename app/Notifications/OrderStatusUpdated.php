<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $oldStatus,
        public string $newStatus
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $o = $this->order;

        $title = match ($this->newStatus) {
            'paid'      => "Payment received for Order #{$o->id}",
            'completed' => "Order #{$o->id} completed",
            'cancelled' => "Order #{$o->id} cancelled",
            default     => "Order #{$o->id} status updated",
        };

        return (new MailMessage)
            ->subject($title)
            ->greeting("Hi {$notifiable->name},")
            ->line("Your order #{$o->id} status changed:")
            ->line("From: " . ucfirst($this->oldStatus))
            ->line("To: " . ucfirst($this->newStatus))
            ->line("Total: LKR " . number_format($o->total, 2))
            ->action('View My Orders', route('orders.my'))
            ->line('Thank you for shopping with Essantra!');
    }
}
