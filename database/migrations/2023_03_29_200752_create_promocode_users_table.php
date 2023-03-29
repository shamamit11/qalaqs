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
        Schema::create('promocode_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promocode_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('num_of_usuage')->nullable();
            $table->foreign('promocode_id')->references('id')->on('promocodes')->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocode_users');
    }
};
