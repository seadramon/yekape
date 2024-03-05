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
        Schema::create('kontraktors', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('jenis', 20);
            $table->string('alamat', 400)->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('hp', 16)->nullable();
            $table->string('pic_nama', 255)->nullable();
            $table->string('pic_jabatan', 255)->nullable();
            $table->string('pic_ktp', 50)->nullable();
            $table->string('npwp', 50)->nullable();
            $table->foreignId('bagian_id')->nullable()->constrained('bagians');
            $table->string('keterangan', 255)->nullable();
            $table->foreignId('created_id')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontraktors');
    }
};
