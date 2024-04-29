<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DeleteProfileController extends Controller
{
    public function deleteProfile($id)
    {
        $userProfile = UserProfile::findOrFail($id);
        $this->authorize('delete', $userProfile);
        $messageType = UserProfile::deleteProfile($userProfile) ? 'success' : 'error';
        $message = $messageType == 'success' ? 'User Profile deleted successfully' : 'Error deleting user';

        return Redirect::back()->with($messageType, $message);
    }
}
