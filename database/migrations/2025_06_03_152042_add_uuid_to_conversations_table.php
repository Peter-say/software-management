<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
             $table->uuid('uuid')->unique()->after('id'); 
        });
        DB::table('conversations')->get()->each(function ($conversation) {
            DB::table('conversations')
                ->where('id', $conversation->id)
                ->update(['uuid' => Str::uuid()]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
             $table->dropColumn('uuid');
        });
    }
};
