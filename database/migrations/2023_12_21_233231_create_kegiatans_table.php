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
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 250);
            $table->string('tahun', 6)->nullable();
            $table->foreignId('program_id')->nullable()->constrained('program');
            $table->foreignId('bagian_id')->nullable()->constrained('bagians');
            $table->decimal('saldo', 12, 2)->nullable();
            $table->decimal('serapan', 12, 2)->nullable();
            $table->string('status', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('kegiatan_detail', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('kegiatan_id')->constrained('kegiatan');
            $table->string('kode_perkiraan', 250);
            $table->nullableMorphs('komponen');
            $table->decimal('harga_satuan', 14, 2);
            $table->decimal('volume', 14, 2);
            $table->decimal('ppn', 14, 2);
            $table->string('keterangan', 250)->nullable();
            $table->string('status', 50)->nullable();
            $table->string('status_anggaran', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->primary('id');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_detail');
        Schema::dropIfExists('kegiatan');
    }
};
