<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CertificationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('certification_levels')->insert([
            [
                'name' => "Level 1",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Level 2 / PCC Bridge",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "MCCP",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Level 3",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
        ]);
    }
}
