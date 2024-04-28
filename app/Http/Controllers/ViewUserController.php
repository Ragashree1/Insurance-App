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

class ViewUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewUsers()
    {
        $this->authorize('viewAny', User::class);
        return Inertia::render('Users/Index', ['users' => User::getUsers(), 'search' => null]);
    }

}
