<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrentFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('current_functions')->insert([
            [
                'name' => "Strategy and Planning",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Operations",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Sales",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Human Resources",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Marketing",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Production",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Purchase",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Organizational Development",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Learning and Development",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Finance and Accounting",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Research and Development",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Entrepreneur",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Non-Profit",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Legal",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Government Service",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Self Employed",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
            [
                'name' => "Diversity and Inclusions",
                'popular' => 0,
                'sort_order' => 0,
                'status' => 'active',
            ],
        ]);
    }
}
