<?php

namespace App\Notifications\Store;

use App\Models\HotelSoftware\StoreItem;
use App\Models\User;
use App\Services\RoleService\HotelServiceRole;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class LowStockcountReminderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $storeItem;
    public $user;
    protected $HotelRoleService;

    public function __construct(StoreItem $storeItem)
    {
        $this->storeItem = $storeItem;
        $this->user = new User();
        $this->HotelRoleService = new HotelServiceRole();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Log::info(['via' => $notifiable, 
        // 'data' => $this->id]);
        return ['mail', 'broadcast', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $data = $this->buildData($notifiable);
        Log::info([
            'data' => $data
        ]);
        $mailMessage = (new MailMessage)
            ->subject('Low Stock Alert: ' . $data['title'])
            ->greeting('Hello!')
            ->line('This is a friendly reminder that the stock for the following item is running low:')
            ->line('**Item Name:** ' . $data['title'])
            ->line('**Current Stock Count:** ' . $data['Item_Count'])
            ->line('**Low Stock Threshold:** ' . $data['Item_Count'])
            ->line($data['message'])
            ->action('View Item', $data['link'])
            ->line('Thank you for using our system!');
        return $mailMessage;
    }

    public function broadcastOn()
    {
        // Check if the user belongs to the hotel and has the correct role
        $roles = $this->HotelRoleService->userCanAccessSalesRole();

        $hasAccess = $this->user->hotelUser
            ->where('hotel_id', $this->user->hotel->id)
            ->whereIn('role', $roles)
            ->exists();
        return $hasAccess ? new Channel('low_stock-alert') : null;
    }

    public function broadcastAs()
    {
        return 'LowStockAlert'; // Matches the 'listen' event in JavaScript
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
            'title' => 'Low Stock Count!',
            'message' => "The stock of ' {$this->storeItem->name} ' is below the minimum threshold.",
            'link' => route('dashboard.hotel.notifications.view', $this->id),
            'Item_Count' => $this->storeItem->low_stock_alert,
            'image' => $this->storeItem ? getStorageUrl('hotel/store/items/files/' .  $this->storeItem->image) : null
        ];
    }
}
