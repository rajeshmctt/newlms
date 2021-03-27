<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('resources')->insert([
            [
                'format' => "document",
                'type' => "link",
                'name' => "ICF Code of Ethics",
                'description' => "The code of ethics published by ICF",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
            [
                'format' => "document",
                'type' => "link",
                'name' => "Demo Session: Coaching - Agreement",
                'description' => "This video shows a demo of doing the agreement phase of a typical coaching session",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
            [
                'format' => "document",
                'type' => "link",
                'name' => "Demo Session: Coaching - Awareness",
                'description' => "This video shows a demo of doing the awareness phase of a typical coaching session",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
            [
                'format' => "document",
                'type' => "link",
                'name' => "Demo Session: Coaching - Action",
                'description' => "This video shows a demo of doing the action phase of a typical coaching session",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
            [
                'format' => "video",
                'type' => "link",
                'name' => "Webinar Series: Using TKI in Coaching",
                'description' => "A webinar by Jayshree Kirtane",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
            [
                'format' => "video",
                'type' => "link",
                'name' => "Webinar Series: Enneagram",
                'description' => "A webinar by Suman Nair",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
            [
                'format' => "video",
                'type' => "link",
                'name' => "Webinar Series: Saville Assessments",
                'description' => "A webinar by Anahat",
                'link' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'status' => 'active',
            ],
        ]);

        DB::table('program_resource')->insert([
            [
                'program_id' => 1,
                'resource_id' => 1,
            ],
            [
                'program_id' => 1,
                'resource_id' => 2,
            ],
            [
                'program_id' => 1,
                'resource_id' => 3,
            ],
            [
                'program_id' => 1,
                'resource_id' => 4,
            ],
            [
                'program_id' => 1,
                'resource_id' => 5,
            ],
            [
                'program_id' => 1,
                'resource_id' => 6,
            ],
            [
                'program_id' => 2,
                'resource_id' => 1,
            ],
            [
                'program_id' => 2,
                'resource_id' => 3,
            ],
            [
                'program_id' => 2,
                'resource_id' => 5,
            ],
            [
                'program_id' => 2,
                'resource_id' => 7,
            ],
        ]);


        DB::table('elective_resource')->insert([
            [
                'elective_id' => 1,
                'resource_id' => 1,
            ],
            [
                'elective_id' => 1,
                'resource_id' => 2,
            ],
            [
                'elective_id' => 1,
                'resource_id' => 3,
            ],
            [
                'elective_id' => 2,
                'resource_id' => 4,
            ],
            [
                'elective_id' => 2,
                'resource_id' => 5,
            ],
            [
                'elective_id' => 3,
                'resource_id' => 6,
            ],
            [
                'elective_id' => 3,
                'resource_id' => 1,
            ],
            [
                'elective_id' => 3,
                'resource_id' => 3,
            ],
            [
                'elective_id' => 4,
                'resource_id' => 5,
            ],
            [
                'elective_id' => 4,
                'resource_id' => 7,
            ],
        ]);
    }
}
