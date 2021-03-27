<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrentCredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('current_credentials')->insert([
            [
                'name' => "None",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "ICF ACC",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "ICF PCC",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "ICF MCC",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
        ]);
    }
}
