<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class UpdateProfileController extends Controller
{
    public function updateUserProfile(String $id)
    {
        $userProfile = UserProfile::findOrFail($id);
        $this->authorize('update', $userProfile);
        $validated = Request::validated([
            'name' => ['required', 'max:50', Rule::unique('user_profile')->ignore($userProfile->id)],
            'description'=> ['nullable','string'],
            'status' => ['required', 'in:active,inactive']
        ]);

        $messageType = 'error';
        $message =  'User Profile not updated';

        if ($userProfile->updateProfile($validated) == true) {
            $messageType = 'success';
            $message =  'User Profile updated successfully';
        }

        return Redirect::back()->with($messageType, $message);
    }
}
