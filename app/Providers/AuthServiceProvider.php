<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('professores', function ($users, $guard = 'professor') {
            if (Auth::guard($guard)->check()){
                return true;
            }
            return false;
        });

        Gate::define('administrador', function ($users, $guard = 'admin') {
            if (Auth::guard($guard)->check() ){
                if (!($users->atendimento == '1')){
                    return true;
                }

            }
            return false;
        });

        Gate::define('atendimento', function ($user) {

            if ($user->atendimento == '1'){
                return true;
            }

            return false;

        });




        //
    }
}
