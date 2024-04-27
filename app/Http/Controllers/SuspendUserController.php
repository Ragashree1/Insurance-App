<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class SuspendUserController extends Controller
{

    public function suspendAccount(User $user)
    {
        $this->authorize('update', $user);
        $user->suspendAccount();

        $messageType = 'success';
        $message = 'User suspended successfully';

        return Redirect::back()->with($messageType, $message);
    }

}
