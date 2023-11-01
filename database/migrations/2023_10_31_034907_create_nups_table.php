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
        Schema::create('nups', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('kavling_id')->constrained('kavlings');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('marketing_id')->constrained('karyawans');
            $table->string('biaya', 100);
            $table->jsonb('data')->default('{}');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nups');
    }
};
