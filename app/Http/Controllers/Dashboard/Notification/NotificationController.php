<?php

namespace App\Http\Controllers\Dashboard\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function unread()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()->latest()->limit(5)->get(); // Fetch unread notifications
        return response()->json(['unread_count' => $user->unreadNotifications->count(), 'notification' => $notifications]);
    }

    public function makeAsRead($id)
    {
        $user = Auth::user(); 
        // Find the notification from the authenticated user's notifications
        $notification = $user->notifications()->find($id);
        
        if ($notification) {
            // Mark the notification as read
            $notification->markAsRead(); 

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function view($uuid)
    {
        $user = Auth::user(); 
        $notification = $user->notifications()->find($uuid);
    }
}
