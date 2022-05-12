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
        // \App\Models\User::factory(10)->create();
        $this->call([DistrictSeeder::class]);
        \App\Models\User::create(['first_name' => 'Louis', 'last_name' => 'Soccard', 'email' => 'louis.soccard@hampshirescouts.org.uk', 'password' => \Illuminate\Support\Facades\Hash::make('password'), 'district_id' => 1]);
    }
}
