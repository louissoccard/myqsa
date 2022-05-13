<?php

namespace Database\Seeders;

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

        $viewUsers = Permission::create(["name" => "admin-centre.users.view"]);
        $modifyUsers = Permission::create(["name" => "admin-centre.users.modify"]);

        $admin = Role::create(["name" => "admin"]);
        $admin->givePermissionTo($viewUsers);
        $admin->givePermissionTo($modifyUsers);
    }
}
