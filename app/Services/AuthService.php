<?php

namespace App\Services;

use App\Models\UserCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function CreateCredentials(Request $request) : UserCredential
    {
        $userCredentials = new UserCredential();

        $userCredentials->email = $request->email;
        $userCredentials->password = Hash::make($request->password);
        $userCredentials->save();

        return $userCredentials;
    }

}