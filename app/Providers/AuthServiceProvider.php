<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

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

        Passport::routes();

        Passport::tokensExpireIn(now()->addDay());

        Passport::refreshTokensExpireIn(now()->addDay());

        Passport::personalAccessTokensExpireIn(now()->addDay());

        Passport::tokensCan([
            'user' => 'User Type',
            'pharmacy' => 'Pharmacy User Type',
            'admin' => 'Admin User Type',
            // TODO API MODEL NAME
        ]);
    }
}
