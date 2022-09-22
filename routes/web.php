<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\My\ResetPasswordController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function(){
    Route::prefix('my')->name('my.')->group(function(){
        Route::get('password', [ResetPasswordController::class, 'edit'])->name('password.edit');
        Route::post('password', [ResetPasswordController::class, 'update'])->name('password.update');
    });
});

Route::group(['middleware' => ['auth', 'can:admin']], function(){
    Route::view('/admin', 'admin')->name('admin');
});
