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
        Schema::create('room_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Assuming user is the staff handling the reservation
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->foreignId('guest_id')->constrained('guests')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->double('rate');
            $table->double('total_amount');
            $table->timestamp('checkin_date')->nullable();
            $table->timestamp('checkout_date')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            $table->string('bill_number')->nullable();
            $table->string('reservation_code')->unique()->nullable();
            $table->string('payment_status')->default('pending'); // Example of payment status
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexing frequently queried columns
            $table->index('guest_id');
            $table->index('room_id');
            $table->index('hotel_id');
            $table->index('checkin_date');
            $table->index('checkout_date');
            $table->index('status');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_reservations');
    }
};
