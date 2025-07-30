<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventscheduleController;
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
Route::get('/events/data', [EventController::class, 'getCalendarEvents'])->name('events.data');
Route::post('/events/by-date', [EventController::class, 'getEventByDate'])->name('events.byDate');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/eventschedule', [EventscheduleController::class, 'view'])->name('eventschedule.view');
Route::post('/eventschedule/store', [EventscheduleController::class, 'store'])->name('eventschedule.store');
Route::get('/events/cards', [EventController::class, 'getEventCards'])->name('events.cards');

Route::get('/dashboard', [CalenderController::class, 'view']);
Route::get('/dashboard-events', [CalenderController::class, 'getEvents']);
Route::get('/calendar/events', [CalenderController::class, 'getEvents'])->name('calender.events');
Route::get('/eventcard', [CalenderController::class, 'index'])->name('eventcard');

Route::get('/customerdashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
Route::get('/customer/events/{id}', [CustomerController::class, 'show'])->name('events.show');
Route::post('/customer/events/{event}/book', [BookingController::class, 'store'])->name('book.event');
 Route::get('/customerevent', [CustomerController::class, 'index'])->name('customer.event');
// Route::get('/mybookings', [CustomerController::class, 'myBookings'])->name('customer.mybookings');
Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('booking.my')->middleware('check.user.role');
Route::post('/eventbooking', [BookingController::class, 'store'])->name('bookings');
Route::post('/bookings/{event}', [BookingController::class, 'store'])->name('bookings.store');


Route::get('/check', function () {
  
})->middleware('check.user.role');









