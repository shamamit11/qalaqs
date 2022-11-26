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
        Schema::create('product_engines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prouct_make_id')->nullable();
            $table->unsignedBigInteger('prouct_model_id')->nullable();
            $table->string('name')->nullable();
            $table->boolean('status')->nullable()->default(1)->comment('0 = hide, 1 = show');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('prouct_make_id')->references('id')->on('product_makes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('prouct_model_id')->references('id')->on('product_models')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_engines');
    }
};
