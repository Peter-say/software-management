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
        Schema::create('software_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('create_by')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable(); // Optional description of the software type
            $table->string('icon')->nullable(); // URL or path to an icon representing the software type
            $table->boolean('is_active')->default(true); // Indicates whether the software type is active
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software_types');
    }
};
