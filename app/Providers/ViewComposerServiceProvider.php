<?php

namespace App\Providers;

use App\Enums\ProjectStatus;
use App\Enums\Permissions;
use App\Models\Project;
use Faker\Provider\ar_EG\Person;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('projects/*', function($view){
            $view->with('parents', Project::whereStatus(ProjectStatus::ACTIVE)->withDepth()->get()->toFlatTree());
        });
        View::composer('roles/*', function($view){
            $view->with('permissions_project', [
                Permissions::EDIT_PROJECT,
                Permissions::CLOSE_PROJECT,
                Permissions::DELETE_PROJECT,
                Permissions::MANAGE_MEMBERS,
            ]);
        });
    }
}
