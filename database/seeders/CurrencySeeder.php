<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            [
                'name' => "INR",
                'code' => "INR",
                'status' => 'active',
            ],
            [
                'name' => "USD",
                'code' => "USD",
                'status' => 'active',
            ],
            [
                'name' => "GBP",
                'code' => "GBP",
                'status' => 'active',
            ],
            [
                'name' => "EUR",
                'code' => "EUR",
                'status' => 'active',
            ],
        ]);
    }
}
