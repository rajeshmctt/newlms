<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecordingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recordings')->insert([
            [
                'type' => "link",
                'name' => "ICF Code of Ethics - Recording",
                'description' => "The code of ethics published by ICF",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
            [
                'type' => "link",
                'name' => "Demo Session: Coaching - Agreement - Recording",
                'description' => "This video shows a demo of doing the agreement phase of a typical coaching session",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
            [
                'type' => "link",
                'name' => "Demo Session: Coaching - Awareness - Recording",
                'description' => "This video shows a demo of doing the awareness phase of a typical coaching session",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
            [
                'type' => "link",
                'name' => "Demo Session: Coaching - Action - Recording",
                'description' => "This video shows a demo of doing the action phase of a typical coaching session",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
            [
                'type' => "link",
                'name' => "Webinar Series: Using TKI in Coaching - Recording",
                'description' => "A webinar by Jayshree Kirtane",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
            [
                'type' => "link",
                'name' => "Webinar Series: Enneagram - Recording",
                'description' => "A webinar by Suman Nair",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
            [
                'type' => "link",
                'name' => "Webinar Series: Saville Assessments - Recording",
                'description' => "A webinar by Anahat",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
        ]);

        DB::table('program_recording')->insert([
            [
                'program_id' => 1,
                'recording_id' => 1,
            ],
            [
                'program_id' => 1,
                'recording_id' => 2,
            ],
            [
                'program_id' => 1,
                'recording_id' => 3,
            ],
            [
                'program_id' => 1,
                'recording_id' => 4,
            ],
            [
                'program_id' => 1,
                'recording_id' => 5,
            ],
            [
                'program_id' => 1,
                'recording_id' => 6,
            ],
            [
                'program_id' => 2,
                'recording_id' => 1,
            ],
            [
                'program_id' => 2,
                'recording_id' => 3,
            ],
            [
                'program_id' => 2,
                'recording_id' => 5,
            ],
            [
                'program_id' => 2,
                'recording_id' => 7,
            ],
        ]);


        DB::table('elective_recording')->insert([
            [
                'elective_id' => 1,
                'recording_id' => 1,
            ],
            [
                'elective_id' => 1,
                'recording_id' => 2,
            ],
            [
                'elective_id' => 1,
                'recording_id' => 3,
            ],
            [
                'elective_id' => 2,
                'recording_id' => 4,
            ],
            [
                'elective_id' => 2,
                'recording_id' => 5,
            ],
            [
                'elective_id' => 3,
                'recording_id' => 6,
            ],
            [
                'elective_id' => 3,
                'recording_id' => 1,
            ],
            [
                'elective_id' => 3,
                'recording_id' => 3,
            ],
            [
                'elective_id' => 4,
                'recording_id' => 5,
            ],
            [
                'elective_id' => 4,
                'recording_id' => 7,
            ],
        ]);
    }
}
