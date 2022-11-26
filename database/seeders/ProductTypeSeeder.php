<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\ProductType;


class ProductTypeSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        ProductType::truncate();
        Schema::enableForeignKeyConstraints();

        $types = [
            ['name' => 'New'],
            ['name' => 'Used'],
        ];

        ProductType::insert($types);
    }
}
