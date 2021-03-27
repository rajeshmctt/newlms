<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            [
                'first_name' => "Admin",
                'last_name' => "",
                'email' => 'info@coach-to-transformation.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('123456Aa'), //123456Aa  CTT_2020
                'phone' => '9893212323',
                'photo' => 'default.png',
                'status' => 'active',
            ],
        ]);
    }
}
