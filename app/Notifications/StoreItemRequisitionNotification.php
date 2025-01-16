<?php

namespace App\Notifications;

use App\Models\RequisitionItem;
use App\Models\User;
use App\Services\RoleService\HotelServiceRole;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StoreItemRequisitionNotification extends Notification
{
    use Queueable;
    public $requisitionItem;
    public $user;
    protected $HotelRoleService;

    public function __construct(RequisitionItem $requisitionItem, User $user, HotelServiceRole $HotelRoleService)
    {
        $this->requisitionItem = $requisitionItem->load('requisition');
        $this->user = $user;
        $this->HotelRoleService = $HotelRoleService;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
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
        $itemsList = $this->requisitionItem->requisition->items->map(function ($item) {
            return $item->item_name . ' (Quantity: ' . $item->quantity . ' ' . $item->unit . ')';
        })->implode("\n");
    
        return (new MailMessage)
            ->subject('New Requisition Submitted') 
            ->line('A new item requisition has been submitted.')
            ->line('Requisition ID: ' . $this->requisitionItem->requisition->id)
            ->line('Department: ' . $this->requisitionItem->requisition->department)
            ->line('Purpose: ' . $this->requisitionItem->requisition->purpose)
            ->line('Status: ' . $this->requisitionItem->requisition->status)
            ->line('Items: ')
            ->line($itemsList) 
            ->action('View Requisition', url('/requisitions/' . $this->requisitionItem->requisition->id)) 
            ->line('Thank you for managing the requisition process.');
    }
    

    public function broadcastOn()
    {
        // Check if the user belongs to the hotel and has the correct role
        $roles = $this->HotelRoleService->userCanAccessSalesRole();

        $hasAccess = $this->user->hotelUser
            ->where('hotel_id', $this->user->hotel->id)
            ->whereIn('role', $roles)
            ->exists();
        return $hasAccess ? new Channel('item-requisition') : null;
    }

    public function broadcastAs()
    {
        return 'RequisitionRequested';
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    protected function buildData($notifiable): array
    {
        return [
            'title' => 'Requisition Submitted!',
            'message' => "A new item requisition was submitted",
            'requisition_id' => $this->requisitionItem->requisition->id,
            'department' => $this->requisitionItem->requisition->department,
            'purpose' => $this->requisitionItem->requisition->purpose,
            'status' => $this->requisitionItem->requisition->status,
            'items' => $this->requisitionItem->requisition->items->map(function ($item) {
                return [
                    'item_name' => $item->item_name ?? 'Unknown Item',
                    'quantity' => $item->quantity,
                    'unit' => $item->unit,
                    // 'image' => $item->restaurantItem ? getStorageUrl('hotel/restaurant/items/' . $item->restaurantItem->image) : null
                ];
            }),
        ];
    }
}
