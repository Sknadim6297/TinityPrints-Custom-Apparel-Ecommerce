<?php

namespace App\Notifications;

use App\Models\RefundRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerRefundStatusNotification extends Notification
{
    use Queueable;

    public function __construct(private RefundRequest $refund)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $orderNumber = $this->refund->order?->order_number ?? 'N/A';
        $status = ucwords(str_replace('_', ' ', $this->refund->status));

        $mail = (new MailMessage)
            ->subject('Refund update for order ' . $orderNumber)
            ->line('Your refund request (' . $this->refund->ticket_id . ') has been updated.')
            ->line('Current status: ' . $status)
            ->line('Order: ' . $orderNumber);

        if ($this->refund->admin_note) {
            $mail->line('Admin note: ' . $this->refund->admin_note);
        }

        return $mail;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->refund->ticket_id,
            'order_id' => $this->refund->order_id,
            'order_number' => $this->refund->order?->order_number,
            'status' => $this->refund->status,
            'status_label' => ucwords(str_replace('_', ' ', $this->refund->status)),
            'admin_note' => $this->refund->admin_note,
        ];
    }
}
