<?php

namespace App\Console\Commands\Store;

use App\Models\HotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelUser;
use App\Models\HotelSoftware\StoreItem;
use App\Models\User;
use App\Notifications\Store\LowStockcountReminderNotification;
use App\Services\RoleService\HotelServiceRole;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class LowStockcountReminderCommand extends Command
{
    public $hotelServiceRole;
    public function __construct()
    {
        parent::__construct();
        $this->hotelServiceRole = new HotelServiceRole();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:low-stockcount-reminder-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for low stock items and send notifications every 3 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $store_items = StoreItem::whereColumn('qty', '<=', 'low_stock_alert')->get();
        foreach ($store_items as $item) {
            $roles =  $this->hotelServiceRole->userCanAccessStoreRole();

            $hotel_users = HotelUser::WhereHas('hotel', function ($query) use ($item) {
                $query->where('hotel_id', $item->store->hotel->id);
            })->whereIn('role', $roles)->get();
            Notification::send($hotel_users, new LowStockcountReminderNotification($item));
            // Log::info(['Low stock notification sent for ' . $item->name, $item->store->hotel->id]);
        }
        $this->info('Low stock notifications have been sent!');
    }
}
