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
        Schema::create('suitablefors', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('make_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('year_id')->nullable();
            $table->unsignedBigInteger('engine_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('make_id')->references('id')->on('makes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('model_id')->references('id')->on('models')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('year_id')->references('id')->on('years')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('engine_id')->references('id')->on('engines')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suitablefors');
    }
};
