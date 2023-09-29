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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_id')->nullable()->index()->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('part_type')->nullable();
            $table->unsignedBigInteger('make_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('year_id')->nullable();
            $table->string('engine')->nullable();
            $table->string('vin')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->foreign('make_id')->references('id')->on('makes')->cascadeOnUpdate();
            $table->foreign('model_id')->references('id')->on('models')->cascadeOnUpdate();
            $table->foreign('year_id')->references('id')->on('years')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
