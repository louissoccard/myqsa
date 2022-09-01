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
        $this->create_participant();
        $this->create_completed_participant();
        $this->create_leader();
        $this->create_admin();

        $users = User::factory()->count(10)->create();
    }

    public function create_participant()
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
    }

    public function create_completed_participant()
    {
        $participant = User::create(['first_name' => 'John', 'last_name' => 'Smith', 'email' => 'completed_yp@myqsa.local', 'password' => Hash::make('password'), 'district_id' => 10]);
        $participant->email_verified_at = now();
        $participant->save();
        $participant->assignRole("participant");

        // Pre-fill certain parts of the award
        $participant->qsa_record->date_of_birth = '2003-04-09';
        $participant->qsa_record->explorers_start = '2020-02-09';
        $participant->qsa_record->network_start = '2021-04-09';
        $participant->qsa_record->dofe_number = '123456';
        $participant->qsa_record->dofe_organisation = 'Hampshire Scouts';
        $participant->qsa_record->dofe_completion = '12/05/2022';
        $participant->qsa_record->dofe_volunteering = 'Complete';
        $participant->qsa_record->dofe_skills = 'Complete';
        $participant->qsa_record->dofe_physical = 'Complete';
        $participant->qsa_record->dofe_expedition = 'Complete';
        $participant->qsa_record->dofe_residential = 'Complete';
        $participant->qsa_record->presentation_name = 'Mike Baxter';
        $participant->qsa_record->presentation_email = 'admin@myqsa.local';
        $participant->qsa_record->presentation_date = '2022-08-10';
        $participant->qsa_record->presentation_statement = 'John delivered an engaging and informative presentation to his local Explorer unit. He covered all parts of the award in great detail and made sure all the Explorers understand the steps he had undertaken to achieve his award.';
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
        $participant->qsa_record->nights_away()->create([
            'name' => 'Gilwell Reunion',
            'start_date' => '2021-09-04',
            'type' => 'Camping',
            'number_of_nights' => 4,
        ]);
        $participant->qsa_record->nights_away()->create([
            'name' => 'Theme Park Camp',
            'start_date' => '2021-09-12',
            'type' => 'Camping',
            'number_of_nights' => 2,
        ]);
        $participant->qsa_record->nights_away()->create([
            'name' => 'Christmas Camp',
            'start_date' => '2020-12-03',
            'type' => 'Indoors',
            'number_of_nights' => 3,
        ]);
        $participant->qsa_record->icv_activities()->create([
            'category' => 'International',
            'start_date' => '2021-04-04',
            'end_date' => '2021-06-23',
            'description' => 'Ran four sessions for my Cub pack about China, exploring local Scouting and their culture.',
            'part_of_csa' => true,
        ]);
        $participant->qsa_record->icv_activities()->create([
            'category' => 'International',
            'start_date' => '2020-02-23',
            'end_date' => '2020-03-04',
            'description' => 'Completed my Explorer Belt in France, travelling 80km around the north east documenting the local produce.',
            'part_of_csa' => true,
        ]);
        $participant->qsa_record->icv_activities()->create([
            'category' => 'Community',
            'start_date' => '2021-09-12',
            'end_date' => '2021-09-13',
            'description' => 'Ran an overnight litter picking competition for local Explorer units with a prize for the largest collection.',
            'part_of_csa' => false,
        ]);
        $participant->qsa_record->icv_activities()->create([
            'category' => 'Community',
            'start_date' => '2019-09-12',
            'end_date' => '2020-01-04',
            'description' => 'Ran weekly bingo sessions at my local care home with prizes supplied by parents of my Scout group.',
            'part_of_csa' => false,
        ]);
        $participant->qsa_record->icv_activities()->create([
            'category' => 'Values',
            'start_date' => '2022-04-12',
            'end_date' => '2022-08-04',
            'description' => 'Helped organise and maintain a local display for the Queen\'s Platinum Jubilee with the local council.',
            'part_of_csa' => false,
        ]);
        $participant->qsa_record->icv_activities()->create([
            'category' => 'Values',
            'start_date' => '2019-10-12',
            'end_date' => '2019-11-11',
            'description' => 'Supported my local church with special information boards about local war heroes and helped plan the remembrance service.',
            'part_of_csa' => false,
        ]);
    }

    public function create_leader()
    {
        $leader = User::create(['first_name' => 'Nick', 'last_name' => 'Goldring', 'email' => 'leader@myqsa.local', 'password' => Hash::make('password'), 'district_id' => 1]);
        $leader->email_verified_at = now();
        $leader->save();
        $leader->assignRole("leader");

        foreach (District::all() as $district) {
            $leader->givePermissionTo("participants.district-$district->id.view");
            $leader->givePermissionTo("participants.district-$district->id.edit");
        }
    }

    public function create_admin()
    {
        $admin = User::create(['first_name' => 'Mike', 'last_name' => 'Baxter', 'email' => 'admin@myqsa.local', 'password' => Hash::make('password'), 'district_id' => 1]);
        $admin->email_verified_at = now();
        $admin->save();
        $admin->assignRole("admin");
    }
}
