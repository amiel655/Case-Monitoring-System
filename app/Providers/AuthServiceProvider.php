<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Gate::define('isStaff', function ($user) {
            return $user->type === 'Staff';
        });

        Gate::define('isAdminAndSuperAdmin', function ($user) {
            return $user->type === 'Admin' || $user->type === 'Super Admin';
        });

        Gate::define('isAdmin', function($user) {
            return $user->type === 'Admin';
        });

        Gate::define('isStaffAndSuperAdmin', function ($user) {
            return $user->type === 'Staff' || $user->type === 'Super Admin';
        });

        Gate::define('isSuperAdmin', function ($user) {
            return $user->type === 'Super Admin';
        });
    }
}
