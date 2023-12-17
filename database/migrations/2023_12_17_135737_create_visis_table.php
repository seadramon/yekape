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
        Schema::create('visi', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 250);
            $table->string('tahun', 6)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('misi', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 250);
            $table->string('tahun', 6)->nullable();
            $table->foreignId('visi_id')->constrained('visi');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('sasaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 250);
            $table->string('tahun', 6)->nullable();
            $table->foreignId('misi_id')->constrained('misi');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('program', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 250);
            $table->string('tahun', 6)->nullable();
            $table->foreignId('sasaran_id')->constrained('sasaran');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
        Schema::dropIfExists('program');
        Schema::dropIfExists('sasaran');
        Schema::dropIfExists('misi');
        Schema::dropIfExists('visi');
    }
};
