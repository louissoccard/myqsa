<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        $participant = User::create(['first_name' => 'Louis', 'last_name' => 'Soccard', 'email' => 'louis.soccard@hampshirescouts.org.uk', 'password' => Hash::make('password'), 'district_id' => 1]);
        $participant->email_verified_at = now();
        $participant->save();
        $participant->assignRole("participant");

        $admin = User::create(['first_name' => 'Mike', 'last_name' => 'Baxter', 'email' => 'louis.soccard@tadleyscouts.org.uk', 'password' => Hash::make('password'), 'district_id' => 1]);
        $admin->email_verified_at = now();
        $admin->save();
        $admin->assignRole("admin");

        $users = User::factory()->count(10)->create();
    }
}
