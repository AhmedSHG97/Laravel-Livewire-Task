<?php

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Logout;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register user routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "user" middleware group. Now create something great!
|
*/



//default prefix is 'admin'
Route::group(['middleware' => 'admin.auth'],function(){
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});

// admin.auth
Route::get('/login', function () {
    return view('session/login-session');
})->name('login');