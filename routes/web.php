<?php

use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\EnumerationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\IssueStatusController;
use App\Http\Controllers\My\SettingController;
use App\Http\Controllers\My\ResetPasswordController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrackerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkflowController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function(){
    return view('test');
});

Auth::routes();

Route::get('/admin/info', [InfoController::class, 'info'])->name('admin.info');

Route::group(['middleware' => 'auth'], function(){
    Route::prefix('my')->name('my.')->group(function(){
        Route::get('/password', [ResetPasswordController::class, 'edit'])->name('password.edit');
        Route::post('/password', [ResetPasswordController::class, 'update'])->name('password.update');
        Route::get('/setting', [SettingController::class, 'edit'])->name('setting.edit');
        Route::put('/setting', [SettingController::class, 'update'])->name('setting.update');
    });
});

Route::group(['middleware' => ['auth', 'usercheck']], function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::group(['middleware' => ['auth', 'usercheck', 'can:admin']], function(){
    Route::view('/admin', 'admin')->name('admin');
});

Route::group(['middleware' => ['auth', 'usercheck']], function(){
    Route::controller(UserController::class)->prefix('users')->name('users.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/{user}', 'show')->name('show');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}/edit', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
        Route::put('/{user}/lock', 'lock')->name('lock');
        Route::put('/{user}/unlock', 'unlock')->name('unlock');
    });
    Route::controller(GroupController::class)->prefix('groups')->name('groups.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/{group}', 'show')->name('show');
        Route::get('/{group}/edit', 'edit')->name('edit');
        Route::put('/{group}/edit', 'update')->name('update');
        Route::delete('/{group}', 'destroy')->name('destroy');
        Route::get('/{group}/users', 'users')->name('users');
        Route::get('/{group}/projects', 'projects')->name('projects');
    });
});

Route::group([], function(){
    Route::controller(ProjectController::class)->prefix('projects')->name('projects.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{project}', 'show')->name('show');
    });
});



Route::group(['middleware' => ['auth', 'usercheck']], function(){
    Route::controller(ProjectController::class)->prefix('projects')->name('projects.')->group(function(){
        Route::get('/admin', 'admin')->name('admin');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/{project}/edit/setting', 'edit')->name('edit.setting');
        Route::put('/{project}/edit/setting', 'update')->name('update.setting');
        Route::get('/{project}/edit/member', 'member')->name('edit.member');
        Route::get('/{project}/edit/issues', 'issues')->name('edit.issues');
        Route::put('/{project}/edit/issues', 'issues_update')->name('update.issues');
        Route::delete('{project}', 'destroy')->name('destroy');
        Route::put('/{project}/open', 'open')->name('open');
        Route::put('/{project}/close', 'close')->name('close');
        Route::put('/{project}/archive', 'archive')->name('archive');
    });
});

Route::group([], function(){
    Route::controller(IssueController::class)->prefix('issues')->name('issues.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{project}', 'show')->name('show');
    });
});

Route::group(['middleware' => ['auth', 'usercheck']], function(){
    Route::controller(IssueController::class)->prefix('projects')->name('issues.')->group(function(){
        Route::get('/{project}/issues', 'index_project')->name('index_project');
        Route::get('/{project}/issues/create', 'create_project')->name('create_project');
        Route::post('/{project}/issues', 'store_project')->name('store_project');
    });
});

Route::group(['middleware' => ['auth', 'usercheck']], function(){
    Route::controller(IssueController::class)->prefix('issues')->name('issues.')->group(function(){
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/{issue}/edit', 'edit')->name('edit');
        Route::put('/{issue}/edit', 'update')->name('update');
        Route::delete('{issue}', 'destroy')->name('destroy');
    });
});

Route::group(['middleware' => ['auth', 'usercheck', 'can:admin']], function(){
    Route::controller(RoleController::class)->prefix('roles')->name('roles.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/{role}/edit', 'edit')->name('edit');
        Route::put('/{role}/edit', 'update')->name('update');
        Route::delete('/{role}', 'destroy')->name('destroy');
        Route::put('/move', 'move')->name('move');
    });
});

Route::group(['middleware' => ['auth', 'usercheck', 'can:admin']], function(){
    Route::controller(IssueStatusController::class)->prefix('issue_status')->name('issue_statuses.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{issue_status}/edit', 'edit')->name('edit');
        Route::put('/{issue_status}/edit', 'update')->name('update');
        Route::delete('/{issue_status}', 'destroy')->name('destroy');
        Route::put('/move', 'move')->name('move');
    });

    Route::controller(EnumerationController::class)->prefix('enumerations')->name('enumerations.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{enumeration}/edit', 'edit')->name('edit');
        Route::put('/{enumeration}/edit', 'update')->name('update');
        Route::delete('/{enumeration}', 'destroy')->name('destroy');
        Route::put('/move', 'move')->name('move');
    });

    Route::controller(TrackerController::class)->prefix('trackers')->name('trackers.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{tracker}/edit', 'edit')->name('edit');
        Route::put('/{tracker}/edit', 'update')->name('update');
        Route::delete('/{tracker}', 'destroy')->name('destroy');
        Route::put('/move', 'move')->name('move');
    });

    Route::controller(WorkflowController::class)->prefix('workflows')->name('workflows.')->group(function(){
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/edit', 'update')->name('update');
    });
});