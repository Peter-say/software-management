<?php

namespace App\Http\Controllers\Dashboard\Notification;

use App\Http\Controllers\Controller;
use App\Models\hotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelUser;
use App\Models\hotelSoftware\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected function authorizeRole()
    {
        $user =  Auth::user();
        $hotelUser = HotelUser::where('user_id', $user->id)->first();
        return $hotelUser->role === 'Hotel_Owner' || $hotelUser->role === 'Manager' || $hotelUser->role === 'Sales';
    }

    public function unread()
    {
        if (!$this->authorizeRole()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $notifications = $user->unreadNotifications()->latest()->get(); // Fetch unread notifications
        return response()->json([
            'unread_count' => $user->unreadNotifications->count(),
            'notification' => $notifications
        ]);
    }

    public function fetchAll()
    {
        if (!$this->authorizeRole()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $notifications = $user->notifications()->latest()->get(); // Fetch unread notifications
        return response()->json([
            'notification' => $notifications
        ]);
    }

    public function makeAsRead($id)
    {
        if (!$this->authorizeRole()) {
            abort(403, 'Unauthorized');
        }

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
        if (!$this->authorizeRole()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $notification = $user->notifications()
        ->where('notifiable_id', $user->hotel->id)->find($uuid);

        if ($notification) {
            // Customize this view with relevant data for display
            return view('notifications.view', ['notification' => $notification]);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }

    public function viewAll()
    {
        if (!$this->authorizeRole()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $notifications = $user->notifications()
            ->where('notifiable_id', $user->hotel->id)  // hotel ID associated with the user
            ->latest()
            ->paginate(20);
        // Customize this view with relevant data for displaying all notifications
        return view('dashboard.notification.order.index', ['notifications' => $notifications]);
    }

    public function deleteNotification($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json(['success' => true]);
    }

    public function deleteBulk(Request $request)
    {
        $notificationIds = $request->input('notificationIds');
        Notification::whereIn('id', $notificationIds)->delete();

        return response()->json(['success' => true]);
    }
}
