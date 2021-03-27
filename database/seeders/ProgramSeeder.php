<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('programs')->insert([
        //     [
        //         'agreement_id' => 3,
        //         'name' => "ICF Coach Certification Program (PCC)",
        //         'description' => 'This program provides ACSTH Certificate training for participants looking at achieving ACC, PCC or MCC credentials with International Coach Federation',
        //         'image' => 'default.png',
        //         'zero_cost_electives' => 2,
        //         'status' => 'active',
        //     ],
        //     [
        //         'agreement_id' => 3,
        //         'name' => "Global Online Coach Certification Program (ACC)",
        //         'description' => 'This program provides ACTP Certificate training for participants looking at achieving ACC, PCC or MCC credentials with International Coach Federation',
        //         'image' => 'default.png',
        //         'zero_cost_electives' => 2,
        //         'status' => 'active',
        //     ],
        //     [
        //         'agreement_id' => 3,
        //         'name' => "Global Online Coach Certification Program (MCC)",
        //         'description' => 'This program provides ACTP Certificate training for participants looking at achieving ACC, PCC or MCC credentials with International Coach Federation',
        //         'image' => 'default.png',
        //         'zero_cost_electives' => 2,
        //         'status' => 'active',
        //     ],
        //     [
        //         'agreement_id' => 3,
        //         'name' => "MCCP Online Program",
        //         'description' => 'This program provides ACTP Certificate training for participants looking at achieving ACC, PCC or MCC credentials with International Coach Federation',
        //         'image' => 'default.png',
        //         'zero_cost_electives' => 2,
        //         'status' => 'active',
        //     ],
        //     [
        //         'agreement_id' => 3,
        //         'name' => "Mentor Coaching",
        //         'description' => 'This program provides ACTP Certificate training for participants looking at achieving ACC, PCC or MCC credentials with International Coach Federation',
        //         'image' => 'default.png',
        //         'zero_cost_electives' => 2,
        //         'status' => 'active',
        //     ],
        // ]);

        DB::table('program_faculty')->insert([
            [
                'program_id' => 21,
                'faculty_id' => 35,
            ],
            [
                'program_id' => 22,
                'faculty_id' => 170,
            ],
            [
                'program_id' => 23,
                'faculty_id' => 262,
            ],
            [
                'program_id' => 24,
                'faculty_id' => 368,
            ],
            [
                'program_id' => 25,
                'faculty_id' => 370,
            ],
        ]);
    }
}
