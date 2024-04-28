<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class SuspendUserController extends Controller
{

    public function suspendAccount(String $id)
    {
        // build in function inside framework
        $user = User::findOrFail($id);
        
        $this->authorize('update', $user);
        $user->suspendAccount();

        $messageType = 'success';
        $message = 'User suspended successfully';

        return Redirect::back()->with($messageType, $message);
    }

}
