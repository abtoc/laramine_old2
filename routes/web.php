<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\My\ResetPasswordController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => 'auth'], function(){
    Route::prefix('my')->name('my.')->group(function(){
        Route::get('/password', [ResetPasswordController::class, 'edit'])->name('password.edit');
        Route::post('/password', [ResetPasswordController::class, 'update'])->name('password.update');
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
        Route::post('/', 'store')->name('store');
        Route::get('/{user}', 'show')->name('show');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
        Route::post('/{user}/lock', 'lock')->name('lock');
        Route::post('/{user}/unlock', 'unlock')->name('unlock');
    });
    Route::controller(GroupController::class)->prefix('groups')->name('groups.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{group}', 'show')->name('show');
        Route::get('/{group}/edit', 'edit')->name('edit');
        Route::put('/{group}', 'update')->name('update');
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
        Route::get('/admin', 'index_admin')->name('admin');
        Route::get('/{project}/edit', 'edit')->name('edit');
    });
});