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
        Schema::create('kavlings', function (Blueprint $table) {
            $table->id();
            $table->integer('tanah_mentah_id')->nullable();
            $table->integer('perkiraan_id')->nullable();
            $table->string('no_pbb')->nullable();
            $table->string('no_shgb')->nullable();
            $table->string('no_imb')->nullable();
            $table->string('nama')->nullable();
            $table->string('blok')->nullable();
            $table->string('nomor')->nullable();
            $table->string('letak')->nullable();
            $table->double('luas_bangun', 8, 2)->nullable();
            $table->double('luas_tanah', 8, 2)->nullable();
            $table->string('alamat_op')->nullable();
            $table->date('tgl_kirim_marketing')->nullable();
            $table->string('status_legal')->nullable();
            $table->double('harga_tunai', 8, 2)->nullable();
            $table->double('harga_kpr', 8, 2)->nullable();
            $table->double('uang_muka_kpr', 8, 2)->nullable();
            $table->dateTime('doc')->nullable();
            $table->string('user_entry')->nullable();
            $table->integer('batal')->nullable();
            $table->dateTime('tgl_batal')->nullable();
            $table->string('user_batal')->nullable();
            $table->string('nopel_pdam')->nullable();
            $table->string('nopel_pln')->nullable();
            $table->string('kota')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('daya_listrik')->nullable();
            $table->string('tipe')->nullable();
            $table->string('keterangan')->nullable();
            $table->date('tgl_sertifikat')->nullable();
            $table->string('kode_kavling')->nullable();
            $table->integer('status_kavling_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kavlings');
    }
};
