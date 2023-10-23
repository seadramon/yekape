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
        Schema::create('spr', function (Blueprint $table) {
            $table->id();
            $table->string('no_sp')->nullable();
            $table->date('tgl_sp')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('kavling_id')->nullable();
            $table->string('tipe_pembelian')->nullable();
            $table->string('jenis_pembeli')->nullable();
            $table->string('bank_kpr')->nullable();
            $table->decimal('harga_jual', 10, 0)->nullable();
            $table->decimal('harga_dasar', 10, 0)->nullable();
            $table->decimal('ppn', 10, 0)->nullable();
            $table->decimal('rp_admin', 10, 0)->nullable();
            $table->decimal('rp_uangmuka', 10, 0)->nullable();
            $table->decimal('masa_bangun', 10, 0)->nullable();
            $table->date('mulai_bangun')->nullable();
            $table->date('selesai_bangun')->nullable();
            $table->decimal('sisa_um', 10, 0)->nullable();
            $table->integer('lm_angsuran')->nullable();
            $table->string('p_angsuran_awal')->nullable();
            $table->string('p_angsuran_akhir')->nullable();
            $table->decimal('rp_angsuran', 10, 0)->nullable();
            $table->decimal('sisa_pembayaran', 10, 0)->nullable();
            $table->string('no_sppk')->nullable();
            $table->date('tgl_sppk')->nullable();
            $table->date('rencana_ajb')->nullable();
            $table->string('jenis_rumah')->nullable();
            $table->integer('marketing_id')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->string('status')->nullable();
            $table->string('lokasi_rmh')->nullable();
            $table->string('type_rmh')->nullable();
            $table->dateTime('doc')->nullable();
            $table->string('user_entry')->nullable();
            $table->dateTime('tgl_batal')->nullable();
            $table->string('user_batal')->nullable();
            $table->decimal('um_0', 10, 0)->nullable();
            $table->string('batal', 10)->nullable();
            $table->decimal('nilai_angsuran', 10, 0)->nullable();
            $table->date('tgl_ajb')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spr');
    }
};
