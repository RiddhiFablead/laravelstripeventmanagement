<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\User1Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/customerdashboard', function () {
    return view('customerdashboard');
});
Route::get('/profile', function () {
    return view('profile');
})->name('profile');
Route::get('/changepassword', function () {
    return view('changepassword');
})->name('changepassword');
Route::post('/change-password', [User1Controller::class, 'updatePassword'])->name('password.update');

Route::get('/logout', [User1Controller::class, 'logout'])->name('logout');


Route::get('/login', [User1Controller::class, 'showUser'])->name('showuser');
Route::post('/login', [User1Controller::class, 'user'])->name('login');
Route::post('/profile', [User1Controller::class, 'updateProfile'])->name('profile.update');
Route::view('/change-password', 'change-password')->name('password.form');
Route::post('/change-password', [User1Controller::class, 'updatePassword'])->name('password.update');
