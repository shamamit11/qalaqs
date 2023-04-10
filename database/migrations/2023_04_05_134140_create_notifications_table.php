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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('device_id')->nullable();
            $table->bigInteger('receiver_id')->nullable();
            $table->enum('receiver_type', ['U', 'V'])->default('V')->comment('U = User, V = Vendor')->nullable();
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->boolean('status')->nullable()->default(1)->comment('0 = unread, 1 = read');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
