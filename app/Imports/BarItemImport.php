<?php

namespace App\Imports;

use App\Models\HotelSoftware\BarItem;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\AfterImport;

class BarItemImport implements ToModel, WithStartRow
{
    public $outlet_id;
    public $importedItemCount = 0;
    public $skippedItems = []; // Array to store skipped items

    public function __construct()
    {
        $defaultRestaurant = User::getAuthenticatedUser()->hotel->defaultBar();
        if (!$this->outlet_id) {
            if ($defaultRestaurant) {
                // If outlet_id is not set, assign the default restaurant's ID
                $this->outlet_id = $defaultRestaurant->id;
            } else {
                // Throw an exception if no default restaurant is found
                throw ValidationException::withMessages([
                    'outlet' => 'You need to create a restaurant outlet before you can add items to it.'
                ]);
            }
        }
    }

    public function startRow(): int
    {
        // Specify the row number to start the import from
        return 2; // Skip the first row (header row)
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Check if the item already exists
        $existingItem = BarItem::where('name', $row[0])
            ->where('outlet_id', $this->outlet_id)
            ->first();

        if ($existingItem) {
            // Optionally, update the existing item with new data
            $existingItem->update([
                'category' => $row[1],
                'name' => $row[0],
                'price' => $row[2],
                'description' => $row[3],
                'is_available' => true, // Assuming the availability is true by default
            ]);

            // Add the item name to the skipped items array
            $this->skippedItems[] = $row[0];
        } else {
            // Create a new item
            $this->importedItemCount++;
            return new BarItem([
                'category' => $row[1],
                'name' => $row[0],
                'price' => $row[2],
                'outlet_id' => $this->outlet_id,
                'description' => $row[3],
                'is_available' => true, // Assuming the availability is true by default
            ]);
        }
    }


    public function registerEvents(): array
    {
        return [
            AfterImport::class => function (AfterImport $event) {
                // Access the imported item count from the import class
                $this->importedItemCount = $event->getConcernable()->importedItemCount;

                // You can log or handle skipped items here
                // For example, logging skipped items
                if (!empty($this->skippedItems)) {
                    Log::info('Skipped Items: ' . implode(', ', $this->skippedItems));
                }
            },
        ];
    }
}
