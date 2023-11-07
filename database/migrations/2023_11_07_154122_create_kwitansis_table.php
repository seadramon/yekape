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
        Schema::create('kwitansis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 30);
            $table->string('jenis_kwitansi', 30);
            $table->string('jenis_penerimaan', 30);
            $table->date('tanggal');
            $table->string('nama', 400)->nullable();
            $table->string('keterangan', 400)->nullable();
            $table->string('alamat', 400)->nullable();
            $table->string('tipe_bayar', 30)->nullable();
            $table->string('bank', 50)->nullable();
            $table->date('tanggal_transfer');
            $table->decimal('jumlah', 12, 2)->nullable();
            $table->decimal('dpp', 12, 2)->nullable();
            $table->decimal('ppn', 12, 2)->nullable();
            $table->decimal('administrasi', 12, 2)->nullable();
            $table->decimal('denda', 12, 2)->nullable();
            $table->nullableMorphs('source');
            $table->foreignId('created_by')->nullable()->constrained('karyawans');
            $table->integer('counter')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kwitansis');
    }
};
