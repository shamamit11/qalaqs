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
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->enum('discount_type', ['A', 'P'])->default('P')->comment('A = Amount, P = Percentage');
            $table->integer('value')->nullable();
            $table->integer('max_num_usage')->nullable();
            $table->integer('max_num_per_user')->nullable();
            $table->boolean('status')->default(1)->comment('0 = inactive, 1 = active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocodes');
    }
};
