<?php

namespace App\Services\Credentials;

use App\Entities\Credentials\UserCredentialModel;
use Illuminate\Support\Facades\Hash;

class UserCredentialService
{
    /*
    No se si sera de utilidad

    public function emailExists(string $email): bool
    {
        return UserCredentialModel::where('email', $email)->exists();
    }

    public function emailIsUniqe(string $email) : array
    {
        $validationErrors = array();

        if($this->emailExists($email))
        {
            $validationErrors['email'] = 'El email recibido pertenece a otro usuario';
        }

        return $validationErrors;
    }
    */

    public function hashPassword(string $password) : string
    {
        return Hash::make($password);
    }
}
