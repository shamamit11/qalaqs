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
        Schema::create('temp_quote_items', function (Blueprint $table) {
            $table->id();
            $table->string('quote_session_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('part_image')->nullable();
            $table->string('part_name')->nullable();
            $table->string('part_number')->nullable();
            $table->string('qty')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_quote_items');
    }
};
