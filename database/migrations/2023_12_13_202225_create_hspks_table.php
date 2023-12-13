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
        Schema::create('hspk', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50);
            $table->string('nama', 250);
            $table->string('satuan', 250);
            $table->decimal('harga', 14, 2);
            $table->decimal('ppn', 14, 2)->nullable();
            $table->string('tipe', 50)->nullable();
            $table->string('tahun', 6)->nullable();
            $table->string('status', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('hspk_details', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('hspk_id')->constrained('hspk');
            $table->nullableMorphs('member');
            $table->decimal('volume', 14, 2);
            $table->decimal('harga_satuan', 14, 2);
            $table->decimal('total', 14, 2);
            $table->decimal('ppn', 14, 2)->nullable();
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
        Schema::dropIfExists('hspk_details');
        Schema::dropIfExists('hspk');
    }
};
