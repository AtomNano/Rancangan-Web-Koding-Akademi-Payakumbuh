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

        // Generate URLs for notifications - skip URL modification as data is read-only
        // URLs should be generated in the Notification class itself or in the view
        $unreadNotifications = $unreadNotifications->map(function ($notification) {
            $data = $notification->data;
            if (isset($data['materi_id']) && !isset($data['url'])) {
                $data['url'] = route('admin.materi.show', $data['materi_id']);
            }
            $notification->computed_url = $data['url'] ?? null;
            return $notification;
        });

        $readNotifications = $readNotifications->map(function ($notification) {
            $data = $notification->data;
            if (isset($data['materi_id']) && !isset($data['url'])) {
                $data['url'] = route('admin.materi.show', $data['materi_id']);
            }
            $notification->computed_url = $data['url'] ?? null;
            return $notification;
        });

        // Return JSON for API/AJAX/fetch requests; otherwise redirect to dashboard
        if (request()->expectsJson() || request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'unread' => $unreadNotifications,
                'read' => $readNotifications,
                'unread_count' => $unreadNotifications->count(),
            ]);
        }

        // For direct browser hits, avoid showing raw JSON and send users to their dashboard
        return redirect()->route('dashboard');
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
