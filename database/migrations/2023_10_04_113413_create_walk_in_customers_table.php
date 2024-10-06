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
        Schema::create('walk_in_customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Customer's name
            $table->string('email')->nullable(); // Customer's email
            $table->string('phone')->nullable(); // Customer's phone number
            $table->text('notes')->nullable(); // Additional notes (e.g., preferences)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walk_in_customers');
    }
};
