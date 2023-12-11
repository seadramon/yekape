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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50);
            $table->string('nik', 50)->nullable();
            $table->string('nama', 200)->nullable();
            $table->string('jenis_kelamin', 2)->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('no_hp', 50)->nullable();
            $table->string('alamat_ktp', 50)->nullable();
            $table->string('alamat_domisili', 50)->nullable();
            $table->foreignId('jabatan_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
