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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->string('cart_session_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('item_count');
            $table->decimal('sub_total', 12, 2)->nullable();
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('cart_session_id')->references('session_id')->on('carts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnUpdate();
            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
