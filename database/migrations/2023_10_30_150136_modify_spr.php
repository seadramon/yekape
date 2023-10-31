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
            $table->jsonb('data')->default('{}');
            $table->integer('counter')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('spr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spr', function (Blueprint $table) {
            $table->dropColumn(['data', 'counter', 'parent_id']);
        });
    }
};
