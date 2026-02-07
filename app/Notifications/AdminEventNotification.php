<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminEventNotification extends Notification
{
    use Queueable;

    private string $title;
    private string $message;
    private string $category;
    private ?string $actionUrl;
    private ?string $actionText;
    private array $meta;

    public function __construct(
        string $title,
        string $message,
        string $category = 'info',
        ?string $actionUrl = null,
        ?string $actionText = null,
        array $meta = []
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->category = $category;
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;
        $this->meta = $meta;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject($this->title)
            ->line($this->message);

        if ($this->actionUrl) {
            $mail->action($this->actionText ?? 'View details', $this->actionUrl);
        }

        return $mail;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'category' => $this->category,
            'action_url' => $this->actionUrl,
            'action_text' => $this->actionText,
            'meta' => $this->meta,
        ];
    }
}
