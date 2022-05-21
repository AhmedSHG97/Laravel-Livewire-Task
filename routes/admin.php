<?php

use App\Http\Livewire\Admin\Company\Company;
use App\Http\Livewire\Admin\Company\Ed;
use App\Http\Livewire\Admin\Company\EditCompany;
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
    Route::get('/companies', Company::class)->name('company');
    Route::get('/company/edit/{id}', EditCompany::class);
});

// admin.auth
Route::get('/login', function () {
    return view('session/login-session');
})->name('login');