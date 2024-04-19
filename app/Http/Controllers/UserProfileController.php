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
        // Fetch all user profiles with their associated user profiles
        $userProfiles = UserProfile::all();
        // dd($userProfiles);
        return Inertia::render('UserProfile/Index', ['userProfile' => $userProfiles]);
    }

    /**
     * Show the form for creating a new resource.
     * I dont get it...
     */
    public function create(UserProfile $userProfile)
    {
        $this->authorize('view', $userProfile);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserProfileRequest $request)
    {
        $this->authorize('create', UserProfile::class);
        $validated = $request->validate([
            'profile_name' => ['required', 'max:50'],
            'description'=> ['nullable','string'],
            'status' => ['required', 'in:active,inactive']
        ]);
        
        $messageType = 'error';
        $message =  'User not created';

        if (UserProfile::create($validated)) {
            $messageType = 'success';
            $message =  'User Profile created successfully';
        }

        return Redirect::back()->with('success', 'User Profile created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserProfile $userProfile)
    {
        $this->authorize('view', $userProfile);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserProfile $editProfile)
    {
        $this->authorize('view', $editProfile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserProfile $userProfile)
    {
        $this->authorize('update', $userProfile);
        $validated = Request::validate([
            'profile_name' => ['required', 'max:50', Rule::unique('userProfile')->ignore($user->id)],
            'description'=> ['nullable','string'],
            'status' => ['required', 'in:active,inactive']
        ]);

        $messageType = 'error';
        $message =  'User Profile not updated';

        if ($userProfile->update($validated) == true) {
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

        $messageType = $user->delete() ? 'success' : 'error';
        $message = $messageType == 'success' ? 'User Profile deleted successfully' : 'Error deleting user';

        return Redirect::back()->with($messageType, $message);
    }
}
