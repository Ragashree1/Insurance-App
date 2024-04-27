<?php

use App\Http\Controllers\ActivateUserController;
use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\DeleteUserController;
use App\Http\Controllers\SuspendUserController;
use App\Http\Controllers\UpdateUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ViewUserController;
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

//comment
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
    // Route::resource('/users', UserController::class);
    Route::post('/users', [CreateUserController::class, 'store'])->name('users.store');
    Route::get('/users', [ViewUserController::class, 'viewUsers'])->name('users.index');
    Route::put('/users/{id}/update', [UpdateUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}/destroy', [DeleteUserController::class, 'destroy'])->name('users.destroy');

    Route::put('users/{id}/activate-account', [ActivateUserController::class, 'activateAccount'])->name('users.activate-account');
    Route::put('users/{id}/suspend-account', [SuspendUserController::class, 'suspendAccount'])->name('users.suspend-account');
    Route::put('users/{id}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
    Route::resource('/userProfile', UserProfileController::class);
});
