<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserProfileRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', UserProfile::class);
        $userProfiles = UserProfile::getAllProfiles();
        return Inertia::render('UserProfile/Index', ['userProfile' => $userProfiles]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserProfileRequest $request)
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


    /**
     * Update the specified resource in storage.
     */
    public function update(UserProfile $userProfile)
    {
        $this->authorize('update', $userProfile);
        $validated = Request::validate([
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserProfile $userProfile)
    {
        $this->authorize('delete', $userProfile);
        $messageType = UserProfile::deleteProfile($userProfile) ? 'success' : 'error';
        $message = $messageType == 'success' ? 'User Profile deleted successfully' : 'Error deleting user';

        return Redirect::back()->with($messageType, $message);
    }
}
