<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('labels')->insert([
            [
                'name' => "New",
                'status' => 'active',
            ],
            [
                'name' => "Bestseller",
                'status' => 'active',
            ],
            [
                'name' => "Partner Program",
                'status' => 'active',
            ],
        ]);
    }
}
