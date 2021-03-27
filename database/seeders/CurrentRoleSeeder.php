<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrentRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('current_roles')->insert([
            [
                'name' => "Top Management",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Mid Management",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "First Time Manager",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Founder Member",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Coach",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Trainer",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Member",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Independent Consultant",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
        ]);
    }
}
