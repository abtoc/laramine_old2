<?php

namespace App\Providers;

use App\Enums\ProjectStatus;
use App\Enums\Permissions;
use App\Models\IssueStatus;
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
            $view->with('parents', Project::select(['id', 'name'])
                                    ->whereStatus(ProjectStatus::ACTIVE)
                                    ->withDepth()
                                    ->get()->toFlatTree());
        });
        View::composer('roles/*', function($view){
            $view->with('permissions_project', [
                Permissions::EDIT_PROJECT,
                Permissions::CLOSE_PROJECT,
                Permissions::DELETE_PROJECT,
                Permissions::MANAGE_MEMBERS,
                Permissions::ADD_SUBPROJECTS,
            ]);
            $view->with('permissions_issue', [
                Permissions::VIEW_ISSUE,
                Permissions::ADD_ISSUE,
                Permissions::EDIT_ISSUE,
                Permissions::EDIT_OWN_ISSUE,
                Permissions::COPY_ISSUE,
                Permissions::MANAGE_ISSUE_RELATIONS,
                Permissions::MANAGE_SUBTASKS,
                Permissions::SET_ISSUES_PRIVATE,
                Permissions::SET_OWN_ISSUES_PRIVATE,
            ]);
        });
        View::composer('trackers/*', function($view){
            $view->with('issue_statuses', IssueStatus::query()->get());
            $view->with('projects', Project::query()
                                        ->activeOrClosed()
                                        ->withDepth()
                                        ->get()->toTree());
        });
    }
}
