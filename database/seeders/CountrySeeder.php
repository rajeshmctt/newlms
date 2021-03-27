<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            [
                'id' => 9,
                'name' => "India",
                'status' => 'active',
            ],
            [
                'id' => 10,
                'name' => "UK",
                'status' => 'active',
            ],
            [
                'id' => 11,
                'name' => "Malaysia",
                'status' => 'active',
            ],
            [
                'id' => 12,
                'name' => "Singapore",
                'status' => 'active',
            ],
            [
                'id' => 13,
                'name' => "UAE",
                'status' => 'active',
            ],
            [
                'id' => 14,
                'name' => "SArabia",
                'status' => 'active',
            ],
            [
                'id' => 15,
                'name' => "Srilanka",
                'status' => 'active',
            ],
            [
                'id' => 16,
                'name' => "Nigeria",
                'status' => 'active',
            ],
            [
                'id' => 17,
                'name' => "Carribean",
                'status' => 'active',
            ],
            [
                'id' => 18,
                'name' => "US",
                'status' => 'active',
            ],
            [
                'id' => 19,
                'name' => "Spain",
                'status' => 'active',
            ],
            [
                'id' => 20,
                'name' => "HongKong",
                'status' => 'active',
            ],
            [
                'id' => 21,
                'name' => "Bangladesh",
                'status' => 'active',
            ],
        ]);
    }
}
