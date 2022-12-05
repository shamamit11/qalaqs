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
        Schema::create('product_years', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_make_id')->nullable();
            $table->unsignedBigInteger('product_model_id')->nullable();
            $table->year('name')->nullable();
            $table->boolean('status')->nullable()->default(1)->comment('0 = hide, 1 = show');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('product_make_id')->references('id')->on('product_makes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('product_model_id')->references('id')->on('product_models')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_years');
    }
};
