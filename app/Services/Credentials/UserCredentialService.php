<?php

namespace App\Services\Credentials;

use App\Entities\Credentials\UserCredentialModel;
use Illuminate\Support\Facades\Hash;

class UserCredentialService
{
    public function emailExists(string $email): bool
    {
        return UserCredentialModel::where('email', $email)->exists();
    }

    public function hashPassword(string $password) : string
    {
        return Hash::make($password);
    }
}
