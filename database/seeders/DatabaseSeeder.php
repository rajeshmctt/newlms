<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $this->call([
            // CountrySeeder::class,
            // LocationSeeder::class,
            // AdminSeeder::class,

            CurrentRoleSeeder::class,
            CurrentFunctionSeeder::class,
            CurrentCredentialSeeder::class,
            CertificationLevelSeeder::class,
            LabelSeeder::class,
            CurrencySeeder::class,
            CoachTypeSeeder::class,
            GlobalAnnouncementSeeder::class,
            // AgreementSeeder::class,
            // UserSeeder::class,
            // FacultySeeder::class,
            // ProgramSeeder::class,
            // ElectiveSeeder::class,
            // BatchSeeder::class,
            // ElectiveBatchSeeder::class,
            // ResourceSeeder::class,
            // RecordingSeeder::class,
        ]);
    }
}
