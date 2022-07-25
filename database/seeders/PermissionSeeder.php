<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hasQSA = Permission::create(["name" => "qsa.has"]);

        $participant = Role::create(["name" => "participant"]);
        $participant->givePermissionTo($hasQSA);

        // Participant permissions of the form: participants.{district|group}-id.{view|edit}
        foreach (District::all() as $district) {
            $view = Permission::create(["name" => "participants.district-$district->id.view"]);
            $edit = Permission::create(["name" => "participants.district-$district->id.edit"]);
        }

        $leader = Role::create(["name" => "leader"]);

        $viewUsers = Permission::create(["name" => "admin-centre.users.view"]);
        $modifyUsers = Permission::create(["name" => "admin-centre.users.modify"]);

        $admin = Role::create(["name" => "admin"]);
        $admin->givePermissionTo($viewUsers);
        $admin->givePermissionTo($modifyUsers);
    }
}
