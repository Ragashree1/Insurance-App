<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class searchUserController extends Controller
{
    //
    public function searchUser(String $name)
    {
        $this->authorize('viewAny', User::class);
        return Inertia::render('Users/Index', ['users' => User::searchUser($name), 'search' => $name]);
    }

}
