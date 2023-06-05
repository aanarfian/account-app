<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnsecuredAuthController;

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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// unsecured authentication
Route::prefix('unsecured')->name('unsecured.')->group(function () {
    // login
    Route::get('/loginView', function () {
        return view('unsecured.login');
    })->name("loginView");

    Route::get('/login', [UnsecuredAuthController::class, 'login'])->name("login");

    // register
    Route::get('/registerView', function () {
        return view('unsecured.register');
    })->name("registerView");
    Route::get('/register', [UnsecuredAuthController::class, 'register'])->name("register");
});


