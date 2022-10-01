<?php

namespace App\Providers;

use Illuminate\Auth\Access\Response as ResponseResult;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        App\Models\User::class => App\Policies\UserPolicy::class,
        App\Models\Group::class => App\Policies\GroupPolicy::class,
        App\Models\Project::class => App\Policies\ProjectPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function($user){
            return $user->admin
                ? ResponseResult::allow()
                : ResponseResult::denyAsNotFound();            
        });      
        Gate::define('admin-users', function($user){
            return  $user->admin_users
                ? ResponseResult::allow()
                : ResponseResult::denyAsNotFound();            
        });      
        Gate::define('admin-projects', function($user){
            return  $user->admin_projects
                ? ResponseResult::allow()
                : ResponseResult::denyAsNotFound();            
        });      
    }
}
