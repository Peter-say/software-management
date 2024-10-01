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
            $table->foreignId('restaurant_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('restaurant_item_id')->constrained()->onDelete('cascade');
            $table->double('qty');
            $table->double('amount');
            $table->double('tax_rate');
            $table->double('tax_amount');
            $table->double('discount_rate');
            $table->string('discount_type');
            $table->double('discount_amount');
            $table->double('total_amount');
            $table->timestamps();
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
