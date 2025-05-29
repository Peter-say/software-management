<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop the existing foreign key
        Schema::table('stores', function (Blueprint $table) {
            $table->dropForeign(['hotel_id']);
        });

        // Re-add the foreign key with cascade on delete
        Schema::table('stores', function (Blueprint $table) {
            $table->foreign('hotel_id')
                  ->references('id')
                  ->on('hotels')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Revert back to original (no cascade)
        Schema::table('stores', function (Blueprint $table) {
            $table->dropForeign(['hotel_id']);
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->foreign('hotel_id')
                  ->references('id')
                  ->on('hotels'); // Default is RESTRICT (no cascade)
        });
    }
};
