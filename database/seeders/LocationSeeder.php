<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            [
                'id' => 33,
                'country_id' => 9,
                'name' => "Mumbai",
                'status' => 'active',
            ],
            [
                'id' => 34,
                'country_id' => 9,
                'name' => "Bengaluru",
                'status' => 'active',
            ],
        ]);
    }
}
