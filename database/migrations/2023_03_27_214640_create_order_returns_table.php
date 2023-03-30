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
        Schema::create('order_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('order_item_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->longText('reason')->nullable();
            $table->boolean('status')->nullable()->default(1)->comment('0 = inactive, 1 = active');
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnUpdate();
            $table->foreign('order_item_id')->references('id')->on('order_items')->cascadeOnUpdate();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_returns');
    }
};
