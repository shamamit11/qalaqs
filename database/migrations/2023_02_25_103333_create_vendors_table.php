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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_code')->nullable();
            $table->string('business_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('image')->nullable();
            $table->string('license_image')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('verification_code')->nullable();
            $table->string('account_type')->nullable()->default('Individual')->comment('Individual / Garage');
            $table->boolean('email_verified')->default(0)->comment('0 = not verified, 1 = verified');
            $table->boolean('admin_approved')->default(0)->comment('0 = no, 1 = yes');
            $table->boolean('status')->nullable()->default(1)->comment('0 = inactive, 1 = active');
            $table->boolean('is_deleted')->default(0)->comment('0 = No, 1 = Yes');
            $table->rememberToken();
            $table->string('device_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
