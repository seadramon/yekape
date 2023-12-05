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
        Schema::create('ssh', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 250);
            $table->string('keterangan', 400)->nullable();
            $table->decimal('harga', 14, 2);
            $table->decimal('ppn', 14, 2)->nullable();
            $table->string('satuan', 150)->nullable();
            $table->string('tahun', 6)->nullable();
            $table->string('tipe', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ssh');
    }
};
