<?php

namespace App\Notifications;

use App\Models\HotelSoftware\RestaurantOrder;
use App\Models\User;
use App\Providers\HotelRoleServiceProvider;
use App\Services\RoleService\HotelServiceRole;
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
    protected $HotelRoleService;

    public function __construct(RestaurantOrder $restaurantOrder, User $user, HotelServiceRole $HotelRoleService)
    {
        $this->restaurantOrder = $restaurantOrder->load('restaurantOrderItems.restaurantItem');
        $this->user = $user;
        $this->HotelRoleService = $HotelRoleService;
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
        $itemsList = $this->restaurantOrder->restaurantOrderItems->map(function ($item) {
            return $item->restaurantItem->name . ' (Quantity: ' . $item->qty . ')';
        })->implode("\n");

        return (new MailMessage)
            ->subject('New Kitchen Order Created')
            ->line('A new order has been created in the kitchen.')
            ->line('Order ID: ' . $this->restaurantOrder->id)
            ->line('Total Amount: $' . $this->restaurantOrder->total_amount)
            ->line('Status: ' . $this->restaurantOrder->status)
            ->line('Items in the order:')
            ->line($itemsList)
            ->action('View Order', url($this->buildData($notifiable)['link']))
            ->line('Thank you for managing the kitchen orders!');
    }


    public function broadcastOn()
    {
        // Check if the user belongs to the hotel and has the correct role
        $roles = $this->HotelRoleService->userCanAccessSalesRole();

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
        $items = $this->restaurantOrder->restaurantOrderItems;
        $itemCount = $items->count();

        $title = $itemCount === 1 ? 'Restaurant Order Created!' : 'Restaurant Orders Created!';
        $message = $itemCount === 1 ? "A new order was created" : "$itemCount restaurant orders were created";

        return [
            'title' => $title,
            'message' => $message,
            'order_id' => $this->restaurantOrder->id,
            'total_amount' => $this->restaurantOrder->total_amount,
            'link' => route('dashboard.hotel.notifications.view', $this->id),
            'status' => $this->restaurantOrder->status,
            'items' => $items->map(function ($item) {
                return [
                    'name' => $item->restaurantItem ? $item->restaurantItem->name : 'Unknown Item',
                    'quantity' => $item->qty,
                    'image' => $item->restaurantItem?->image ? getStorageUrl('hotel/restaurant/items/' . $item->restaurantItem->image) :  getStorageUrl('dashboard/drink/wiskey.jpeg')
                ];
            }),
        ];
    }
}
