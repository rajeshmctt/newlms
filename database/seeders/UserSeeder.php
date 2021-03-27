<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'first_name' => "Kashyap",
                'last_name' => "Panwala",
                'email' => 'kashyap@thefifthinsight.co',
                'password' => Hash::make('123456Aa'),
                'description' => 'This is test description for Kashyap. This is test description for Kashyap. This is test description for Kashyap. This is test description for Kashyap. This is test description for Kashyap.',
                'phone' => '(91)989278-7678',
                'photo' => 'default.png',
                // 'current_icf_credential' => 'ACC',
                'facebook_profile_url' => 'http://www.facebook.com/',
                'linkedin_profile_url' => 'http://www.linkedin.com',
                'instagram_profile_url' => 'http://www.instagram.com',
                'twitter_profile_url' => 'http://www.twitter.com',
                'status' => 'active',
            ],
            [
                'first_name' => "Niranjan",
                'last_name' => "Shanbhag",
                'email' => 'niranjan.shanbhag@thefifthinsight.co',
                'password' => Hash::make('123456Aa'),
                'description' => 'Test Description for NS',
                'phone' => '(1)293-79-2749',
                'photo' => 'default.png',
                // 'current_icf_credential' => 'PCC',
                'facebook_profile_url' => 'http://www.facebook.com/',
                'linkedin_profile_url' => 'http://www.linkedin.com',
                'instagram_profile_url' => 'http://www.instagram.com',
                'twitter_profile_url' => 'http://www.twitter.com',
                'status' => 'active',
            ],
            [
                'first_name' => "Sharath",
                'last_name' => "Bodapati",
                'email' => 'sharathbodapati@gmail.com',
                'password' => Hash::make('123456Aa'),
                'description' => 'Test Description for SB',
                'phone' => '(65)2857.128.12',
                'photo' => 'default.png',
                // 'current_icf_credential' => 'PCC',
                'facebook_profile_url' => 'http://www.facebook.com/',
                'linkedin_profile_url' => 'http://www.linkedin.com',
                'instagram_profile_url' => 'http://www.instagram.com',
                'twitter_profile_url' => 'http://www.twitter.com',
                'status' => 'active',
            ]
        ]);
    }
}
