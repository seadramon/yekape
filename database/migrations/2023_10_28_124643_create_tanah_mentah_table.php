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
        Schema::create('tanah_mentah', function (Blueprint $table) {
            $table->id();
            $table->string('no_skrk')->nullable();
            $table->string('no_pbb')->nullable();
            $table->string('no_shgb')->nullable();
            $table->integer('perkiraan_id')->nullable();
            $table->string('nama')->nullable();
            $table->double('luas_tanah')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('nama_wp')->nullable();
            $table->string('alamat_wp')->nullable();
            $table->string('alamat_op')->nullable();
            $table->dateTime('doc')->nullable();
            $table->string('user_entry')->nullable();
            $table->integer('batal')->default(0);
            $table->dateTime('tgl_batal')->nullable();
            $table->string('user_batal')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('status')->nullable();
            $table->double('sisa_tanah')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanah_mentah');
    }
};
