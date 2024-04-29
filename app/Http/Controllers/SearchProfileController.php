<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchProfileController extends Controller
{
    //
    public function searchProfile(String $name)
    {
        $this->authorize('viewAny', UserProfile::class);
        return Inertia::render('UserProfile/Index', ['userProfile' => UserProfile::searchProfile($name), 'search' => $name]);
    }

}
