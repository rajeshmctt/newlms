<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('batches')->insert([
        //     [
        //         'type' => "self",
        //         'program_id' => 21,
        //         'country_id' => 9,
        //         'location_id' => 33,
        //         'name' => "Batch I",
        //         'start_date' => "2020-12-01",
        //         'end_date' => "2020-12-10",
        //         'status' => 'active',
        //     ],
        //     [
        //         'type' => "self",
        //         'program_id' => 22,
        //         'country_id' => 9,
        //         'location_id' => 33,
        //         'name' => "Batch II",
        //         'start_date' => "2020-12-05",
        //         'end_date' => "2020-12-10",
        //         'status' => 'active',
        //     ],
        //     [
        //         'type' => "self",
        //         'program_id' => 23,
        //         'country_id' => 9,
        //         'location_id' => 33,
        //         'name' => "Batch III",
        //         'start_date' => "2020-12-10",
        //         'end_date' => "2020-12-15",
        //         'status' => 'active',
        //     ],
        //     [
        //         'type' => "self",
        //         'program_id' => 24,
        //         'country_id' => 9,
        //         'location_id' => 33,
        //         'name' => "Batch IV",
        //         'start_date' => "2020-12-15",
        //         'end_date' => "2020-12-20",
        //         'status' => 'active',
        //     ],
        //     [
        //         'type' => "self",
        //         'program_id' => 25,
        //         'country_id' => 9,
        //         'location_id' => 33,
        //         'name' => "Batch V",
        //         'start_date' => "2020-12-20",
        //         'end_date' => "2020-12-25",
        //         'status' => 'active',
        //     ],
        // ]);

        // DB::table('batch_users')->insert([
        //     [
        //         'batch_id' => 1,
        //         'user_id' => 1,
        //         'status' => 'active',
        //     ],
        //     [
        //         'batch_id' => 1,
        //         'user_id' => 2,
        //         'status' => 'active',
        //     ],
        //     [
        //         'batch_id' => 1,
        //         'user_id' => 3,
        //         'status' => 'active',
        //     ],
        //     [
        //         'batch_id' => 2,
        //         'user_id' => 1,
        //         'status' => 'active',
        //     ],
        //     [
        //         'batch_id' => 2,
        //         'user_id' => 2,
        //         'status' => 'active',
        //     ],
        //     [
        //         'batch_id' => 3,
        //         'user_id' => 1,
        //         'status' => 'active',
        //     ],
        // ]);

        DB::table('batch_faculty')->insert([
            [
                'batch_id' => 71,
                'faculty_id' => 35,
            ],
            [
                'batch_id' => 72,
                'faculty_id' => 170,
            ],
            [
                'batch_id' => 73,
                'faculty_id' => 262,
            ],
            [
                'batch_id' => 74,
                'faculty_id' => 368,
            ],
            [
                'batch_id' => 75,
                'faculty_id' => 370,
            ],
        ]);
    }
}
