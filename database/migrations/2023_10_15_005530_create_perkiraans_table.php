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
        Schema::create('perkiraans', function (Blueprint $table) {
            $table->id();
            $table->string('kd_perkiraan', 15)->nullable();
            $table->string('keterangan')->nullable();
            $table->string('tipe', '1')->nullable();
            $table->dateTime('doc')->nullable();
            $table->string('user_entry')->nullable();
            $table->integer('batal')->nullable();
            $table->dateTime('tgl_batal')->nullable();
            $table->string('user_batal')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perkiraans');
    }
};
