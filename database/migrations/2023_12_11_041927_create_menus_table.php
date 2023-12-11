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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->string('route_name', 50)->nullable();
            $table->string('icon', 50)->nullable();
            $table->string('level', 50)->nullable();
            $table->string('seq', 5)->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('action')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('role_menus', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('menu_id')->constrained('menus');
            $table->text('action_menu')->nullable();
            $table->timestamps();
            $table->primary('id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->constrained('roles');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role_id']);
        });
        Schema::dropIfExists('role_menus');
        Schema::dropIfExists('menus');
    }
};
