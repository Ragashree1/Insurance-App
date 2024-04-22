<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        return Inertia::render('Users/Index', ['users' => User::with('userProfile')->where('user_profile_id', null)->orWhere('user_profile_id', '!=', 1)->get()]);
    }


   
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

        $this->authorize('create', User::class);
        $validated = Request::validate([
            'username' => ['required', 'max:50', Rule::unique('users')],
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')],
            'contact' => ['required', 'max:50', Rule::unique('users')],
            'password' => ['nullable', 'string', Password::default(), 'confirmed'],
            'user_profile_id' => ['nullable'],
            'nationality' => ['nullable', 'max:50'],
            'residence_country' => ['nullable', 'max:50'],
            'status' => ['nullable', 'max:50'],
            'dob' => ['required', 'date'],
            'photo' => ['nullable', 'image'],
        ]);

        $validated['profile_photo_path'] = Request::file('photo') ? Request::file('photo')->store('users') : null;

        $messageType = 'error';
        $message =  'User not created';

        $response = User::createUserAccount($validated);

        if ($response) {
            $messageType = 'success';
            $message =  'User created successfully';
        }

        return Redirect::back()->with('success', 'User created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user)
    {
        $this->authorize('update', $user);
        $validated = Request::validate([
            'username' => ['required', 'max:50', Rule::unique('users')->ignore($user->id)],
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')->ignore($user->id)],
            'contact' => ['required', 'max:50', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', Password::default(), 'confirmed'],
            'user_profile_id' => ['nullable'],
            'nationality' => ['nullable', 'max:50'],
            'residence_country' => ['nullable', 'max:50'],
            'status' => ['required', 'max:50'],
            'dob' => ['required', 'date'],
            'photo' => ['nullable', 'image'],
        ]);

        $messageType = 'error';
        $message =  'User not updated';

        if ($user->updateUserAccount($validated) == true) {
            $messageType = 'success';
            $message =  'User updated successfully';
        }

        return Redirect::back()->with($messageType, $message);
    }

    public function suspendAccount(User $user)
    {
        $this->authorize('update', $user);
        $user->suspendAccount();

        $messageType = 'success';
        $message = 'User suspended successfully';

        return Redirect::back()->with($messageType, $message);
    }

    public function activateAccount(User $user)
    {
        $this->authorize('update', $user);
        $user->activateAccount();

        $messageType = 'success';
        $message = 'User activated successfully';

        return Redirect::back()->with($messageType, $message);
    }

    public function assignRole(User $user)
    {
        $this->authorize('update', $user);

        $validated = Request::validate([
            'user_profile_id' => ['nullable', 'integer'],
        ]);

        $user->assignRole($validated['user_profile_id']);
        $messageType = 'success';
        $message = 'User role assigned successfully';

        return Redirect::back()->with($messageType, $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $messageType = User::deleteUserAccount($user) ? 'success' : 'error';
        $message = $messageType == 'success' ? 'User deleted successfully' : 'Error deleting user';

        return Redirect::back()->with($messageType, $message);
    }
}
