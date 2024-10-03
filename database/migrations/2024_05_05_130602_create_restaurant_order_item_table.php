<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restaurant_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_order_id')->constrained('restaurant_orders')->onDelete('cascade'); // Links to restaurant orders
            $table->foreignId('restaurant_item_id')->constrained('restaurant_items')->onDelete('cascade'); // Links to specific menu items
            $table->double('qty'); // Quantity of this item ordered
            $table->double('amount'); // Subtotal for this item
            $table->double('tax_rate'); // Tax rate applied
            $table->double('tax_amount'); // Total tax for this item
            $table->double('discount_rate'); // Discount rate applied
            $table->string('discount_type'); // Type of discount (percentage, fixed)
            $table->double('discount_amount'); // Total discount for this item
            $table->double('total_amount'); // Final amount for this item after tax and discount
            $table->timestamps(); // Created and updated timestamps
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_order_item');
    }
};
