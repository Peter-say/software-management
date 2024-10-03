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
        Schema::create('store_item_restaurant_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_item_id')->constrained('store_items')->onDelete('cascade');
            $table->foreignId('restaurant_item_id')->constrained('restaurant_items')->onDelete('cascade');
            $table->unsignedBigInteger('quantity')->default(0); // Use unsigned for larger values
            $table->timestamps();
        
           // Add a unique constraint with a specified name
            $table->unique(['store_item_id', 'restaurant_item_id'], 'unique_store_item_restaurant_item');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_item_restaurant_item');
    }
};
