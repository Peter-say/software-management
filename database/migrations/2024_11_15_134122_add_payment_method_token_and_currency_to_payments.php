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
        Schema::table('payments', function (Blueprint $table) {
            // Check if the 'currency_id' column exists before adding it
            if (!Schema::hasColumn('payments', 'currency_id')) {
                $table->unsignedBigInteger('currency_id')->nullable()->after('amount'); // Add the column if not exists
            }

            // Check if the 'payment_method_token' column exists before adding it
            if (!Schema::hasColumn('payments', 'payment_method_token')) {
                $table->string('payment_method_token')->nullable()->after('currency_id'); // Add the column if not exists
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Remove the 'currency_id' column if it exists
            if (Schema::hasColumn('payments', 'currency_id')) {
                $table->dropColumn('currency_id');
            }

            // Remove the 'payment_method_token' column if it exists
            if (Schema::hasColumn('payments', 'payment_method_token')) {
                $table->dropColumn('payment_method_token');
            }
        });
    }
};
