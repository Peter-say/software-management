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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->string('title');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('other_names')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('other_phone')->nullable();
            $table->string('id_picture_location')->nullable();
            $table->date('birthday')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
