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

class CreateUserController extends Controller
{

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

        return Redirect::back()->with($messageType, $message);
    }

}
