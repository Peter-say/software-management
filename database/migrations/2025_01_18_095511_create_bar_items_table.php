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
        Schema::create('bar_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outlet_id')->constrained('outlets')->onDelete('cascade');
            $table->string('name');
            $table->string('image')->nullable();
            $table->double('price');
            $table->string('description')->nullable();
            $table->double('cost')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bar_items');
    }
};
