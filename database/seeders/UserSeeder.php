<?php

namespace Database\Seeders;

use App\Models\District;
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
        $participant = User::create(['first_name' => 'Louis', 'last_name' => 'Soccard', 'email' => 'yp@myqsa.local', 'password' => Hash::make('password'), 'district_id' => 4]);
        $participant->email_verified_at = now();
        $participant->save();
        $participant->assignRole("participant");

        // Pre-fill certain parts of the award
        $participant->qsa_record->date_of_birth = '2004-04-09';
        $participant->qsa_record->explorers_start = '2021-02-09';
        $participant->qsa_record->dofe_volunteering = 'In Progress';
        $participant->qsa_record->dofe_skills = 'Complete';
        $participant->qsa_record->dofe_expedition = 'Complete';
        $participant->qsa_record->save();
        $participant->qsa_record->nights_away()->create([
            'name' => 'Beavers Sleepover',
            'start_date' => '2021-11-06',
            'type' => 'Indoors',
            'number_of_nights' => 1,
        ]);
        $participant->qsa_record->nights_away()->create([
            'name' => 'Cub Camp',
            'start_date' => '2021-07-09',
            'type' => 'Camping',
            'number_of_nights' => 2,
        ]);
        $participant->qsa_record->nights_away()->create([
            'name' => 'Explorer Camp',
            'start_date' => '2021-08-08',
            'type' => 'Camping',
            'number_of_nights' => 6,
        ]);
        $participant->qsa_record->icv_activities()->create([
            'category' => 'International',
            'start_date' => '2021-04-04',
            'end_date' => '2021-06-23',
            'description' => 'Ran four sessions for my Cub pack about China, exploring local Scouting and their culture.',
            'part_of_csa' => true,
        ]);
        $participant->qsa_record->icv_activities()->create([
            'category' => 'Community',
            'start_date' => '2021-09-12',
            'end_date' => '2021-09-13',
            'description' => 'Ran an overnight litter picking competition for local Explorer units with a prize for the largest collection.',
            'part_of_csa' => false,
        ]);

        $leader = User::create(['first_name' => 'Nick', 'last_name' => 'Goldring', 'email' => 'leader@myqsa.local', 'password' => Hash::make('password'), 'district_id' => 1]);
        $leader->email_verified_at = now();
        $leader->save();
        $leader->assignRole("leader");

        foreach (District::all() as $district) {
            $leader->givePermissionTo("participants.district-$district->id.view");
            $leader->givePermissionTo("participants.district-$district->id.edit");
        }

        $admin = User::create(['first_name' => 'Mike', 'last_name' => 'Baxter', 'email' => 'admin@myqsa.local', 'password' => Hash::make('password'), 'district_id' => 1]);
        $admin->email_verified_at = now();
        $admin->save();
        $admin->assignRole("admin");

        $users = User::factory()->count(10)->create();
    }
}
