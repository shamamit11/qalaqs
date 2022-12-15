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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('sku')->nullable();
            $table->string('part_type')->nullable();
            $table->string('part_number')->nullable();
            $table->string('product_type')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->unsignedBigInteger('product_sub_category_id')->nullable();
            $table->unsignedBigInteger('product_brand_id')->nullable();
            $table->unsignedBigInteger('product_make_id')->nullable();
            $table->unsignedBigInteger('product_model_id')->nullable();
            $table->unsignedBigInteger('product_year_id')->nullable();
            $table->unsignedBigInteger('product_engine_id')->nullable();
            $table->string('warranty')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->boolean('status')->nullable()->default(1)->comment('0 = hide, 1 = show');
            $table->boolean('admin_approved')->nullable()->default(0)->comment('0 = No, 1 = Yes');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('product_category_id')->references('id')->on('product_categories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('product_sub_category_id')->references('id')->on('product_sub_categories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('product_brand_id')->references('id')->on('product_brands')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('products');
    }
};