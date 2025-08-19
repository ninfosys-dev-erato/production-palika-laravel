<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BerujuSeeder extends Seeder
{
    /**
     * Run the Beruju-related database seeders.
     */
    public function run(): void
    {
        $this->call([
            BerujuSubCategorySeeder::class,
            BerujuActionTypeSeeder::class,
            BerujuDocumentTypesSeeder::class,
        ]);
    }
}


