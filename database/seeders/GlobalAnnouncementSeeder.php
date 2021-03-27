<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GlobalAnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('global_announcements')->insert([
            [
                'name' => "CTT welcomes it's new partners in Spain and Portugal",
                'description' => "CTT welcomes it's new partners in Spain and Portugal",
                'status' => 'active',
            ],
        ]);
    }
}
