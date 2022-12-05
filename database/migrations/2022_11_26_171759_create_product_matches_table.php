<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('product_make_id')->nullable();
            $table->unsignedBigInteger('product_model_id')->nullable();
            $table->unsignedBigInteger('product_year_id')->nullable();
            $table->unsignedBigInteger('product_engine_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('product_make_id')->references('id')->on('product_makes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('product_model_id')->references('id')->on('product_models')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('product_year_id')->references('id')->on('product_years')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('product_engine_id')->references('id')->on('product_engines')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_matches');
    }
};
