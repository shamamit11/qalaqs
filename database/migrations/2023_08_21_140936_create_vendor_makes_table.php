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
        Schema::create('vendor_makes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('make_id')->nullable();
            $table->unsignedBigInteger('year_from_id')->nullable();
            $table->unsignedBigInteger('year_to_id')->nullable();
            $table->string('part_type')->nullable();
            $table->string('market')->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('make_id')->references('id')->on('makes')->cascadeOnUpdate();
            $table->foreign('year_from_id')->references('id')->on('years')->cascadeOnUpdate();
            $table->foreign('year_to_id')->references('id')->on('years')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_makes');
    }
};
