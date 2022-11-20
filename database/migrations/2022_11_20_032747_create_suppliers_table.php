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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_code')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('coordinates')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('image')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('verification_code')->nullable();
            $table->boolean('email_verified')->default(0)->comment('0 = not verified, 1 = verified');
            $table->boolean('status')->default(1)->comment('0 = inactive, 1 = active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
};
