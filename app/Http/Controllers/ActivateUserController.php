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

class ActivateUserController extends Controller
{

    public function activateAccount(String $id)
    {
        // build in function inside framework
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $user->activateAccount();

        $messageType = 'success';
        $message = 'User activated successfully';

        return Redirect::back()->with($messageType, $message);
    }
}
