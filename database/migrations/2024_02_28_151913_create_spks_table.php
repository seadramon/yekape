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
        Schema::create('spk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 50);
            $table->string('jenis', 50);
            $table->date('tanggal');
            $table->foreignId('kontraktor_id')->nullable()->constrained('kontraktors');
            $table->foreignId('serapan_id')->nullable()->constrained('serapan');
            $table->string('uraian', 400)->nullable();
            $table->decimal('nilai', 14, 2)->nullable();
            $table->decimal('ppn', 10, 0)->nullable();
            $table->decimal('ppn_nilai', 14, 2)->nullable();
            $table->string('path_file', 400)->nullable();
            $table->foreignId('created_id')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spk');
    }
};
