<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserProfileRequest;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CreateProfileController extends Controller
{
    public function createProfile(StoreUserProfileRequest $request)
    {
        $this->authorize('create', UserProfile::class);
        $validated = $request->validate([
            'name' => ['required', 'max:50'],
            'description'=> ['nullable','string'],
            'status' => ['required', 'in:active,inactive']
        ]);
        
        $messageType = 'error';
        $message =  'User Profile not created';

        if (UserProfile::createUserProfile($validated) != null) {
            $messageType = 'success';
            $message =  'User Profile created successfully';
        }

        return Redirect::back()->with($messageType, $message);
    }
}
