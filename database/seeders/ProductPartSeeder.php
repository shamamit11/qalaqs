<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\ProductPart;


class ProductPartSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        ProductPart::truncate();
        Schema::enableForeignKeyConstraints();

        $parts = [
            ['name' => 'Genuine'],
            ['name' => 'OEM'],
        ];

        ProductPart::insert($parts);
    }
}
