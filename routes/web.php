<?php

use App\Http\Controllers\CalenderController;
use App\Http\Controllers\EventController;
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
Route::get('/users/create', [User1Controller::class, 'create'])->name('users.create');
Route::post('/users/store', [User1Controller::class, 'store'])->name('users.store');
Route::get('/users', [User1Controller::class, 'index'])->name('users.index');
Route::get('/users/{id}/edit', [User1Controller::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [User1Controller::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [User1Controller::class, 'destroy'])->name('users.destroy');
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
Route::get('/dashnoard', [CalenderController::class, 'view']);
Route::get('/dashboard-events', [CalenderController::class, 'getEvents']);
Route::get('/eventcard', [EventController::class, 'index'])->name('eventcard.index');



