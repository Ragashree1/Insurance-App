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

class UpdateUserController extends Controller
{

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

}
