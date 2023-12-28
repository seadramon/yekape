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
        Schema::create('serapan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 250);
            $table->string('kode', 250);
            $table->foreignId('bagian_id')->nullable()->constrained('bagians');
            $table->string('metode', 50)->nullable();
            $table->string('jenis', 50)->nullable();
            $table->string('jenis_lelang', 50)->nullable();
            $table->string('jenis_bayar', 50)->nullable();
            $table->date('costing_date')->nullable();
            $table->string('tahun', 6)->nullable();
            $table->string('status', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('serapan_detail', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('serapan_id')->constrained('serapan');
            $table->foreignUuid('kegiatan_detail_id')->constrained('kegiatan_detail');
            $table->decimal('harga_satuan', 14, 2);
            $table->decimal('volume', 14, 2);
            $table->decimal('ppn', 14, 2);
            $table->decimal('ppn_rp', 14, 2);
            $table->decimal('total', 14, 2);
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
        Schema::dropIfExists('serapan_detail');
        Schema::dropIfExists('serapan');
    }
};
