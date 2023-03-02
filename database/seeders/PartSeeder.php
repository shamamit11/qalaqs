<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Part;


class PartSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Part::truncate();
        Schema::enableForeignKeyConstraints();

        $parts = [
            ['name' => 'Genuine'],
            ['name' => 'OEM'],
        ];

        Part::insert($parts);
    }
}
