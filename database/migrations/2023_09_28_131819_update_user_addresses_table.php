<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('building');
            $table->renameColumn('street_name', 'address');
            $table->dropColumn('mobile');
            $table->dropColumn('is_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('building')->nullable();
            $table->renameColumn('address', 'street_name');
            $table->string('mobile')->nullable();
            $table->boolean('is_default')->nullable()->default(0)->comment('0 = No, 1 = Yes');
        });
    }
};