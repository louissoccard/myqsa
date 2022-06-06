<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('access-admin-centre', function (User $user) {
            return $user->getAllPermissions()->filter(fn ($item) => preg_match("#^admin-centre\..*$#", $item->name))->count() > 0;
        });
        Gate::define('access-admin-centre.users', function (User $user) {
           return $user->getAllPermissions()->filter(fn ($item) => preg_match("#^admin-centre\.users\..*$#", $item->name))->count() > 0;
        });
        Gate::define('access-admin-centre.users.modify', function (User $user) {
           return $user->getAllPermissions()->contains("admin-centre.users.modify");
        });
    }
}
