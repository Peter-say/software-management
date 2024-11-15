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
        Schema::create('expense_expense_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->foreignId('expense_id')->constrained()->onDelete('cascade');
            $table->foreignId('expense_item_id')->constrained()->onDelete('cascade');
            $table->double('qty');
            $table->double('rate');
            $table->double('amount');
            $table->double('unit_qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_expense_items');
    }
};
