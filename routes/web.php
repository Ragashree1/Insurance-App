<?php

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Route::get('/', [\Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'login']);


Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', ['profile' => Auth::user()->userProfile()->first()]);
    })->name('dashboard');
    Route::resource('/users', UserController::class);

    Route::put('users/{user}/activate-account', [UserController::class, 'activateAccount'])->name('users.activate-account');
    Route::put('users/{user}/suspend-account', [UserController::class, 'suspendAccount'])->name('users.suspend-account');
    Route::put('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
});
