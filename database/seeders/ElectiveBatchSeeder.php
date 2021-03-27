<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ElectiveBatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('elective_batches')->insert([
            [
                'type' => "online",
                'elective_id' => 1,
                'name' => "Batch I",
                'date' => "2020-11-28",
                'status' => 'active',
            ],
            [
                'type' => "online",
                'elective_id' => 2,
                'name' => "Batch I",
                'date' => "2021-01-23",
                'status' => 'active',
            ],
            [
                'type' => "online",
                'elective_id' => 2,
                'name' => "Batch II",
                'date' => "2021-03-27",
                'status' => 'active',
            ],
            [
                'type' => "online",
                'elective_id' => 3,
                'name' => "Batch I",
                'date' => "2021-03-13",
                'status' => 'active',
            ],
            [
                'type' => "online",
                'elective_id' => 4,
                'name' => "Batch I",
                'date' => "2020-12-12",
                'status' => 'active',
            ],
            [
                'type' => "online",
                'elective_id' => 5,
                'name' => "Batch I",
                'date' => "2021-02-20",
                'status' => 'active',
            ],
            [
                'type' => "online",
                'elective_id' => 6,
                'name' => "Batch I",
                'date' => "2021-01-30",
                'status' => 'active',
            ],
        ]);
    }
}
