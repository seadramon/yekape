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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('no_ktp', 50)->nullable();
            $table->string('nama', 150)->nullable();
            $table->string('telp_1', 50)->nullable();
            $table->string('telp_2')->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 20)->nullable();
            $table->string('jenis_kelamin', 25)->nullable();
            $table->string('alamat', 150)->nullable();
            $table->string('kelurahan', 50)->nullable();
            $table->string('kecamatan', 50)->nullable();
            $table->string('kota', 50)->nullable();
            $table->string('pekerjaan', 50)->nullable();
            $table->string('nama_usaha', 150)->nullable();
            $table->string('telp_usaha', 50)->nullable();
            $table->string('alamat_usaha', 150)->nullable();
            $table->string('no_kk', 50)->nullable();
            $table->string('no_npwp', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->dateTime('doc')->nullable();
            $table->integer('user_entry')->nullable();
            $table->string('status')->nullable();
            $table->string('kewarganegaraan', 10)->nullable();
            $table->string('alamat_domisili')->nullable();
            $table->integer('batal')->default(0);
            $table->string('nama_pajak')->nullable();
            $table->string('alamat_pajak')->nullable();
            $table->string('kota_pajak')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
