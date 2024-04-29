<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ViewProfileController extends Controller
{
    public function viewProfiles()
    {
        $this->authorize('viewAny', UserProfile::class);
        $userProfiles = UserProfile::getAllProfiles();
        return Inertia::render('UserProfile/Index', ['userProfile' => $userProfiles]);
    }

}
