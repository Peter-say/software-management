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
        Schema::create('store_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->foreignId('item_category_id')->constrained('item_categories')->onDelete('cascade');//eg food, drinks, maintenance
            $table->foreignId('item_sub_category_id')->nullable('item_sub_categories')->constrained()->onDelete('cascade');//eg beer, wine, protein
            $table->string('name');
            $table->string('code')->unique();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('unit_measurement'); 
            $table->double('qty')->default(0);
            $table->double('cost_price')->nullable();
            $table->double('selling_price')->nullable();
            $table->double('low_stock_alert')->nullable();
            $table->boolean('for_sale')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_items');
    }
};
