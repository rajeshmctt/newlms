<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoachTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coach_types')->insert([
            [
                'name' => "Faculty",
                'code' => "faculty",
                'status' => 'active',
            ],
            [
                'name' => "Mentor Coach",
                'code' => "mentor-coach",
                'status' => 'active',
            ],
        ]);
    }
}
