<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Gate;

class AuthServiceProvider extends ServiceProvider
{
      /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];


    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         

        Gate::before(function($user){
            if($user->isAdmin())
            {
                return true;
            }
        });

        Gate::define('agent', function($user){
            return $user->isAgent();
        });


        Gate::define('agent_user', function($user){
            return $user->isAgentUser();
        });

        Gate::define('hub_admin', function($user){
            return $user->isHubAdmin();
        });

        Gate::define('hub_user', function($user){
            return $user->isHubUser();
        });

        //Panel Access Gates
        Gate::define('access-admin-panel', fn ($user) =>  $user->canAccessAdminPanel());
        Gate::define('access-agent-panel', fn ($user) =>  $user->canAccessAgentPanel());
        Gate::define('access-hub-panel', fn ($user) =>  $user->canAccessHubPanel());
    }


}
