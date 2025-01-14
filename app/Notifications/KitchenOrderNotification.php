<?php

namespace App\Notifications;

use App\Models\HotelSoftware\RestaurantOrder;
use App\Models\User;
use App\Providers\RoleServiceProvider;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class KitchenOrderNotification extends Notification implements ShouldBroadcast
{
    use Queueable;
    public $restaurantOrder;
    public $user;
    protected $roleProvider;

    public function __construct(RestaurantOrder $restaurantOrder, User $user, RoleServiceProvider $roleProvider)
    {
        $this->restaurantOrder = $restaurantOrder->load('restaurantOrderItems.restaurantItem');
        $this->user = $user;
        $this->roleProvider = $roleProvider;
    }


    // Specify the channels for the notification
    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    // Store the notification in the database
    public function toDatabase($notifiable): array
    {
        return $this->buildData($notifiable);
    }

    // Broadcast the notification via Pusher
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->buildData($notifiable));
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $data = $this->buildData($notifiable);
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function broadcastOn()
    {
        // Check if the user belongs to the hotel and has the correct role
        $roles = $this->roleProvider->userCanAccessSalesRole(); // Retrieve roles from the provider

        $hasAccess = $this->user->hotelUser
            ->where('hotel_id', $this->user->hotel->id)
            ->whereIn('role', $roles)
            ->exists();
        return $hasAccess ? new Channel('kitchen-orders') : null;
    }


    public function broadcastAs()
    {
        return 'OrderCreated'; // Matches the 'listen' event in JavaScript
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            // Additional data for array representation can be added here
        ];
    }

    protected function buildData($notifiable): array
    {
        return [
            'title' => 'Order Created!',
            'message' => "A new order was created",
            'order_id' => $this->restaurantOrder->id,
            'total_amount' => $this->restaurantOrder->total_amount,
            'link' => route('dashboard.hotel.notifications.view', $this->restaurantOrder->id),
            'status' => $this->restaurantOrder->status,
            'items' => $this->restaurantOrder->restaurantOrderItems->map(function ($item) {
                return [
                    'name' => $item->restaurantItem ? $item->restaurantItem->name : 'Unknown Item',
                    'quantity' => $item->qty,
                    'image' => $item->restaurantItem ? getStorageUrl('hotel/restaurant/items/' . $item->restaurantItem->image) : null
                ];
            }),
        ];
    }
}
