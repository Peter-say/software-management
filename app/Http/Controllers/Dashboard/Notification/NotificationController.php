<?php

namespace App\Http\Controllers\Dashboard\Notification;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\HotelUser;
use App\Models\HotelSoftware\Notification;
use App\Services\RoleService\HotelServiceRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public $hotelServiceRole;
    public function __construct()
    {
        $this->hotelServiceRole = new HotelServiceRole();
    }
    protected function authorizeRole()
    {
      return $this->hotelServiceRole->getHotelUserRoles();
    }

    public function unread()
    {
        if (!$this->authorizeRole()) {
            abort(403, 'Unauthorized');
        }
        $user = Auth::user();
        $roles = $this->hotelServiceRole->getHotelUserRoles();
        $notifications = $user->unreadNotifications()->whereHas('notifiable.hotelUser', function ($query) use ($roles) {
            $query->whereIn('role', $roles);
        })->orderBy('created_at', 'desc')->get();

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
        $roles = $this->hotelServiceRole->getHotelUserRoles();
        $notifications = $user->notifications()->whereHas('notifiable.hotelUser', function ($query) use ($roles) {
            $query->whereIn('role', $roles);
        })->latest()->get();
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
// dd($notification);
        if ($notification) {
            return view('dashboard.notification.single', ['notification' => $notification]);
        }

        return back()->with('error_message', 'Notification not found');
    }

    public function viewAll()
    {
        if (!$this->authorizeRole()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $notifications = $user->notifications()
            ->where('notifiable_id', $user->hotel->id)  // hotel ID associated with the user
            ->orderBy('created_at', 'desc')->get()
            ->paginate(20);
        // Customize this view with relevant data for displaying all notifications
        return view('dashboard.notification.index', ['notifications' => $notifications]);
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
