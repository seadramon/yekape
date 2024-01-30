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
        Schema::table('serapan', function (Blueprint $table) {
            $table->foreignId('approval_id')->nullable()->constrained('karyawans');
            $table->string('approval_jabatan', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('serapan', function (Blueprint $table) {
            $table->dropColumn(['approval_id', 'approval_jabatan']);
        });
    }
};
