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
            $table->string('nik', 50);
            $table->string('nama', 200);
            $table->string('jenis_kelamin', 2);
            $table->string('tempat_lahir', 50);
            $table->date('tgl_lahir');
            $table->string('no_hp', 50);
            $table->string('alamat_ktp', 50);
            $table->string('alamat_domisili', 50);
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
