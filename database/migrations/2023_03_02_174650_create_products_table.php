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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('main_image')->nullable();
            $table->string('image_01')->nullable();
            $table->string('image_02')->nullable();
            $table->string('image_03')->nullable();
            $table->string('image_04')->nullable();
            $table->string('title')->nullable();
            $table->string('part_number')->nullable();
            $table->string('sku')->nullable();
            $table->unsignedBigInteger('make_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('year_id')->nullable();
            $table->unsignedBigInteger('engine_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('manufacturer')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('part_type')->nullable();
            $table->string('market')->nullable();
            $table->string('warranty')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->double('discount')->nullable();
            $table->integer('stock')->nullable();
            $table->double('weight')->nullable();
            $table->double('height')->nullable();
            $table->double('width')->nullable();
            $table->double('length')->nullable();
            $table->string('folder')->nullable();
            $table->boolean('status')->nullable()->default(1)->comment('0 = hide, 1 = show');
            $table->boolean('admin_approved')->nullable()->default(0)->comment('0 = No, 1 = Yes');
            $table->boolean('is_featured')->nullable()->default(0)->comment('0 = No, 1 = Yes');
            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('products');
    }
};
