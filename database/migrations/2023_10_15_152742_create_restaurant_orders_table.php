<?php

use App\Constants\StatusConstants;
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
        Schema::create('restaurant_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outlet_id')->constrained('outlets')->onDelete('cascade');
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');;
            $table->foreignId('guest_id')->nullable()->constrained('guests')->onDelete('cascade');
            $table->foreignId('walk_in_customer_id')->nullable()->constrained('walk_in_customers')->onDelete('cascade');
            $table->date('order_date');//shift
            $table->string('status')->default(StatusConstants::OPENED);//open,settled
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
        Schema::dropIfExists('restaurants');
    }
};
