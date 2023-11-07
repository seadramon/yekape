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
        Schema::create('booking_fees', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 50);
            $table->date('tanggal');
            $table->foreignId('kavling_id')->constrained('kavlings');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('marketing_id')->constrained('karyawans');
            $table->decimal('harga_jual', 12, 2)->nullable();
            $table->string('jenis_pembayaran', 50)->nullable();
            $table->decimal('jumlah_pembayaran', 12, 2)->nullable();
            $table->jsonb('data')->default('{}');
            $table->integer('counter')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_fees');
    }
};
