<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Fetch user's notifications.
     */
    public function index()
    {
        $user = Auth::user();

        // Get unread notifications
        $unreadNotifications = $user->unreadNotifications;

        // Get some recent read notifications for context
        $readNotifications = $user->readNotifications()->latest()->limit(5)->get();
        
        return response()->json([
            'unread' => $unreadNotifications,
            'read' => $readNotifications,
            'unread_count' => $unreadNotifications->count(),
        ]);
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Mark all user's notifications as read.
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return response()->json(['status' => 'success']);
    }
}
