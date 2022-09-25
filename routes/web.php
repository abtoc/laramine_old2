<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\My\ResetPasswordController;
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

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::prefix('my')->name('my.')->group(function(){
        Route::get('/password', [ResetPasswordController::class, 'edit'])->name('password.edit');
        Route::post('/password', [ResetPasswordController::class, 'update'])->name('password.update');
    });
});

Route::group(['middleware' => ['auth', 'usercheck']], function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/users/{user}', [UserController::class,'show'])->name('users.show');
});

Route::group(['middleware' => ['auth', 'usercheck', 'can:admin']], function(){
    Route::view('/admin', 'admin')->name('admin');
    Route::controller(UserController::class)->prefix('users')->name('users.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}', 'update')->name('update');
        Route::delete('/users/{user}', 'destroy')->name('destroy');
        Route::post('/{user}/lock', 'lock')->name('lock');
        Route::post('/{user}/unlock', 'unlock')->name('unlock');
    });
});

