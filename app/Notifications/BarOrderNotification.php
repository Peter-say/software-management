<?php

namespace App\Notifications;

use App\Models\HotelSoftware\BarOrder;
use App\Models\User;
use App\Services\RoleService\HotelServiceRole;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class BarOrderNotification extends Notification implements ShouldBroadcast
{
    use Queueable;
    public $barOrder;
    public $user;
    protected $HotelRoleService;

    public function __construct(BarOrder $barOrder, User $user, HotelServiceRole $HotelRoleService)
    {
        $this->barOrder = $barOrder->load('barOrderItems.barItem');
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
        $itemsList = $this->barOrder->barOrderItems->map(function ($item) {
            return $item->barItem->name . ' (Quantity: ' . $item->qty . ')';
        })->implode("\n");

        return (new MailMessage)
            ->subject('New Bar Order Created')
            ->line('A new order has been created in the bar.')
            ->line('Order ID: ' . $this->barOrder->id)
            ->line('Total Amount: $' . $this->barOrder->total_amount)
            ->line('Status: ' . $this->barOrder->status)
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
        $items = $this->barOrder->barOrderItems;
        $itemCount = $items->count();

        $title = $itemCount === 1 ? 'Bar Order Created!' : 'Bar Orders Created!';
        $message = $itemCount === 1 ? "A new order was created in the bar" : "$itemCount bar orders were created";

        return [
            'title' => $title,
            'message' => $message,
            'order_id' => $this->barOrder->id,
            'total_amount' => $this->barOrder->total_amount,
            'link' => route('dashboard.hotel.notifications.view', $this->id),
            'status' => $this->barOrder->status,
            'items' => $items->map(function ($item) {
                return [
                    'name' => $item->barItem ? $item->barItem->name : 'Unknown Item',
                    'quantity' => $item->qty,
                    'image' => $item->barItem ? getStorageUrl('hotel/bar/items/' . $item->barItem->image) : asset('dashboard/drink/wiskey.jpeg')
                ];
            }),
        ];
    }
}
