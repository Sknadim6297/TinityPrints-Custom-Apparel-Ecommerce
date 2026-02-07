<?php

namespace App\Support;

use App\Models\Admin;
use App\Notifications\AdminEventNotification;
use Illuminate\Support\Facades\Notification;

class AdminNotifier
{
    public static function notifyAll(
        string $title,
        string $message,
        string $category = 'info',
        ?string $actionUrl = null,
        ?string $actionText = null,
        array $meta = []
    ): void {
        $admins = Admin::where('is_active', true)->get();

        if ($admins->isEmpty()) {
            return;
        }

        Notification::send($admins, new AdminEventNotification(
            $title,
            $message,
            $category,
            $actionUrl,
            $actionText,
            $meta
        ));
    }
}
