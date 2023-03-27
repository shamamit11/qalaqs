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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('item_count');
            $table->double('vat_percentage')->nullable();
            $table->decimal('vat_amount', 12, 2)->nullable();
            $table->string('promo_code')->nullable();
            $table->string('promo_type')->nullable();
            $table->decimal('promo_value', 12, 2)->nullable();
            $table->decimal('sub_total', 12, 2)->nullable();
            $table->decimal('tax_total', 12, 2)->nullable();
            $table->decimal('delivery_charge', 12, 2)->nullable();
            $table->string('delivery_name')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_country')->nullable();
            $table->string('delivery_zip')->nullable();
            $table->string('delivery_phone')->nullable();
            $table->string('billing_name')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_phone')->nullable();
            $table->text('order_note')->nullable();
            $table->bigInteger('cancel_reason_id')->nullable();
            $table->text('cancel_note')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_transaction_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
