<?php

use Inertia\Inertia;
use App\Models\PropertyListing;
use App\Http\Controllers\searchUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewUserController;
use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\DeleteUserController;
use App\Http\Controllers\UpdateUserController;
use App\Http\Controllers\SuspendUserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ActivateUserController;
use App\Http\Controllers\PropertyListingController;
use PhpParser\Builder\Property;

use App\Http\Controllers\MortgageController;


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
    Route::post('/users', [CreateUserController::class, 'createUser'])->name('users.store');
    Route::get('/users', [ViewUserController::class, 'viewUsers'])->name('users.index');
    Route::put('/users/{id}/update', [UpdateUserController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}/destroy', [DeleteUserController::class, 'destroy'])->name('users.destroy');

    Route::get('users/{name}', [SearchUserController::class, 'searchUser'])->name('search-users');
    Route::put('users/{id}/activate-account', [ActivateUserController::class, 'activateAccount'])->name('users.activate-account');
    Route::put('users/{id}/suspend-account', [SuspendUserController::class, 'suspendAccount'])->name('users.suspend-account');
    Route::put('users/{id}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
    Route::resource('/userProfile', UserProfileController::class);
    
});


// ------------- Listings ------------------------

Route::get('/listings', [PropertyListingController::class, 'allListings'])->name('allListings');

// search a listing
Route::get('/listings/search', [PropertyListingController::class, 'searchListings'])->name('searchListings');

// view single listing
Route::get('/listings/{listing_id}', [PropertyListingController::class, 'viewListing'])->name('viewListing');

// agent create listings
Route::post('/listings/manage/create/{user_id}', [PropertyListingController::class, 'createListing'])->name('createListing');

// agent search listings 
Route::get('listings/manage/search/{user_id}', [PropertyListingController::class, 'agentSearchListings'])->name('agentSearchListings');

// update selected listing
Route::put('listings/manage/update/{listing_id}', [PropertyListingController::class, 'updateListing'])->name('updateListing');

// agent choose the listing to update
Route::get('listings/manage/update/{listing_id}', [PropertyListingController::class, 'listingToUpdate'])->name('listingToUpdate');

// delete listing
Route::delete('listings/manage/delete/{listing_id}', [PropertyListingController::class, 'deleteListing'])->name('deleteListing');

// agent manage listings page - display all listings created by that agent  
Route::get('listings/manage/{user_id}', [PropertyListingController::class, 'viewListingsCreatedByAgent']);



Route::get('/mortgage', function () { return view('CalculateMortgage'); })->name('mortgage');
Route::post('/mortgage', [MortgageController::class, 'calculate'])->name('calculate');


