<?php

namespace Database\Seeders;

use App\Models\HotelSoftware\StoreItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storeItems = [
            [
                'store_id' => 1,
                'item_category_id' => 1,
                'item_sub_category_id' => 1,
                'name' => 'Chicken Breast',
                'code' => StoreItem::generateItemCode(),
                'image' => null,
                'description' => 'Fresh chicken breast, suitable for grilling or baking.',
                'unit_measurement' => 'kg',
                'qty' => 50,
                'cost_price' => 5.00,
                'selling_price' => 8.00,
                'low_stock_alert' => 10,
                'for_sale' => true,
            ],
            [
                'store_id' => 1,
                'item_category_id' => 2,
                'item_sub_category_id' => 2,
                'name' => 'Red Wine',
                'code' => StoreItem::generateItemCode(),
                'image' => null,
                'description' => 'Bottle of red wine from Italy.',
                'unit_measurement' => 'bottle',
                'qty' => 30,
                'cost_price' => 15.00,
                'selling_price' => 25.00,
                'low_stock_alert' => 5,
                'for_sale' => true,
            ],
            [
                'store_id' => 1,
                'item_category_id' => 3,
                'item_sub_category_id' => null,
                'name' => 'Dishwashing Soap',
                'code' => StoreItem::generateItemCode(),
                'image' => null,
                'description' => 'Liquid soap for cleaning dishes.',
                'unit_measurement' => 'litre',
                'qty' => 20,
                'cost_price' => 2.50,
                'selling_price' => 4.00,
                'low_stock_alert' => 5,
                'for_sale' => false,
            ],
            // New Items Added Below
            [
                'store_id' => 1,
                'item_category_id' => 1,
                'item_sub_category_id' => 3,
                'name' => 'Beef Steak',
                'code' => StoreItem::generateItemCode(),
                'image' => null,
                'description' => 'Premium quality beef steak.',
                'unit_measurement' => 'kg',
                'qty' => 40,
                'cost_price' => 2000.00,
                'selling_price' => 2500.00,
                'low_stock_alert' => 5,
                'for_sale' => true,
            ],
            [
                'store_id' => 1,
                'item_category_id' => 2,
                'item_sub_category_id' => 4,
                'name' => 'White Wine',
                'code' => StoreItem::generateItemCode(),
                'image' => null,
                'description' => 'Bottle of white wine from France.',
                'unit_measurement' => 'bottle',
                'qty' => 25,
                'cost_price' => 12.00,
                'selling_price' => 20.00,
                'low_stock_alert' => 5,
                'for_sale' => true,
            ],
            [
                'store_id' => 1,
                'item_category_id' => 4,
                'item_sub_category_id' => null,
                'name' => 'Laundry Detergent',
                'code' => StoreItem::generateItemCode(),
                'image' => null,
                'description' => 'High-efficiency laundry detergent.',
                'unit_measurement' => 'litre',
                'qty' => 15,
                'cost_price' => 3.00,
                'selling_price' => 5.00,
                'low_stock_alert' => 3,
                'for_sale' => false,
            ],
            [
                'store_id' => 1,
                'item_category_id' => 3,
                'item_sub_category_id' => 5,
                'name' => 'Spaghetti',
                'code' => StoreItem::generateItemCode(),
                'image' => null,
                'description' => 'Pack of high-quality spaghetti.',
                'unit_measurement' => 'pack',
                'qty' => 60,
                'cost_price' => 1.50,
                'selling_price' => 2.50,
                'low_stock_alert' => 10,
                'for_sale' => true,
            ],
            [
                'store_id' => 1,
                'item_category_id' => 5,
                'item_sub_category_id' => 6,
                'name' => 'Olive Oil',
                'code' => StoreItem::generateItemCode(),
                'image' => null,
                'description' => 'Extra virgin olive oil.',
                'unit_measurement' => 'litre',
                'qty' => 35,
                'cost_price' => 7.00,
                'selling_price' => 10.00,
                'low_stock_alert' => 5,
                'for_sale' => true,
            ],
        ];

        foreach ($storeItems as $item) {
            DB::table('store_items')->insert($item);
        }
    }
}
