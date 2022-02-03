<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        District::create(['name' => 'Hampshire (County Role)']);
        District::create(['name' => 'Andover']);
        District::create(['name' => 'Basingstoke East']);
        District::create(['name' => 'Basingstoke West']);
        District::create(['name' => 'Blackwater Valley']);
        District::create(['name' => 'Bramshill']);
        District::create(['name' => 'Chandlers Ford']);
        District::create(['name' => 'City of Portsmouth']);
        District::create(['name' => 'Eastleigh']);
        District::create(['name' => 'Fareham East']);
        District::create(['name' => 'Fareham West']);
        District::create(['name' => 'Gosport']);
        District::create(['name' => 'Havant']);
        District::create(['name' => 'Itchen North']);
        District::create(['name' => 'Itchen South']);
        District::create(['name' => 'Meon Valley']);
        District::create(['name' => 'New Forest']);
        District::create(['name' => 'New Forest Solent']);
        District::create(['name' => 'Odiham']);
        District::create(['name' => 'Petersfield']);
        District::create(['name' => 'Romsey']);
        District::create(['name' => 'Rotherfield']);
        District::create(['name' => 'Southampton City']);
        District::create(['name' => 'Waterlooville']);
        District::create(['name' => 'Winchester']);
    }
}
