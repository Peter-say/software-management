<?php

namespace Database\Seeders;

use App\Models\HotelSoftware\ItemCategory;
use App\Models\HotelSoftware\ItemSubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Food',
                'subcategories' => [
                    ['name' => 'Breakfast'],
                    ['name' => 'Lunch'],
                    ['name' => 'Dinner'],
                    ['name' => 'Snacks'],
                ],
            ],
            [
                'name' => 'Drink',
                'subcategories' => [
                    ['name' => 'Alcoholic'],
                    ['name' => 'Non-Alcoholic'],
                    ['name' => 'Hot Beverages'],
                    ['name' => 'Cold Beverages'],
                ],
            ],
            [
                'name' => 'House Keeping',
                'subcategories' => [
                    ['name' => 'Cleaning Supplies'],
                    ['name' => 'Laundry'],
                    ['name' => 'Toiletries'],
                ],
            ],
            [
                'name' => 'Maintenance',
                'subcategories' => [
                    ['name' => 'Plumbing'],
                    ['name' => 'Electrical'],
                    ['name' => 'HVAC'],
                    ['name' => 'Carpentry'],
                ],
            ],
            [
                'name' => 'Staff',
                'subcategories' => [
                    ['name' => 'Uniforms'],
                    ['name' => 'Training Materials'],
                ],
            ],
            [
                'name' => 'Administrative',
                'subcategories' => [
                    ['name' => 'Office Supplies'],
                    ['name' => 'Technology'],
                ],
            ],
            [
                'name' => 'Others',
                'subcategories' => [
                    ['name' => 'Miscellaneous'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            // Create the main category
            $category = ItemCategory::create(['name' => $categoryData['name']]);

            // Create the subcategories
            foreach ($categoryData['subcategories'] as $subcategoryData) {
                ItemSubCategory::create([
                    'item_category_id' => $category->id,
                    'name' => $subcategoryData['name'],
                    'hotel_id' => 1,
                ]);
            }
        }
    }
}
