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
        Schema::create('hotel_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('hotel_id')->nullable()->constrained('hotels')->cascadeOnDelete(); // Ensure the hotel_id references the hotels table
            $table->date('current_shift')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->text('address')->nullable();
            $table->string('role')->default('Hotel_Owner');
            $table->foreignId('user_account_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_users');
    }
};
