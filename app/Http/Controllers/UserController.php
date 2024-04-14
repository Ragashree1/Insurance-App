<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        return Inertia::render('Users/Index', ['users' => User::where('user_profile_id', null)->orWhere('user_profile_id', '!=', 1)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $this->authorize('create', User::class);
        Request::validate([
            'username' => ['required', 'max:50', Rule::unique('users')],
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')],
            'contact' => ['required', 'max:50', Rule::unique('users')],
            'password' => ['nullable'],
            'photo' => ['nullable', 'image'],
        ]);

        $validated['photo_path'] = Request::file('photo') ? Request::file('photo')->store('users') : null;
        $validated['created_by'] = Auth::user()->id;

        Auth::user()->account->users()->create($validated);

        return Redirect::back()->with('success', 'User created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( User $user)
    {
        $this->authorize('update', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
    }
}
