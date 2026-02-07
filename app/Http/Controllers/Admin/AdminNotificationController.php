<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $admin = auth()->guard('admin')->user();
        $notifications = Schema::hasTable('notifications')
            ? $admin->notifications()->paginate(12)
            : collect();

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markRead(string $notificationId)
    {
        if (!Schema::hasTable('notifications')) {
            return redirect()->route('admin.notifications.index');
        }

        $admin = auth()->guard('admin')->user();
        $notification = $admin->notifications()->where('id', $notificationId)->firstOrFail();

        $notification->markAsRead();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification marked as read.');
    }

    public function markAllRead()
    {
        if (!Schema::hasTable('notifications')) {
            return redirect()->route('admin.notifications.index');
        }

        $admin = auth()->guard('admin')->user();
        $admin->unreadNotifications->markAsRead();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'All notifications marked as read.');
    }
}
