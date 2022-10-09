<?php

namespace App\Providers;

use App\Enums\ProjectStatus;
use App\Models\Project;
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
    }
}
