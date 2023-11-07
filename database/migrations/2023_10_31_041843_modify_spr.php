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
        Schema::table('spr', function (Blueprint $table) {
            $table->foreignId('booking_fee_id')->nullable()->constrained();
        });
        Schema::table('kavlings', function (Blueprint $table) {
            $table->foreignId('cluster_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spr', function (Blueprint $table) {
            $table->dropColumn(['booking_fee_id']);
        });
        Schema::table('kavlings', function (Blueprint $table) {
            $table->dropColumn(['cluster_id']);
        });
    }
};
