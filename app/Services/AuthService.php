<?php

namespace App\Services;

use App\Classes\MyResponse;
use App\Classes\MyStatus;
use App\Classes\Status;
use App\Classes\UserAccessData;
use App\Models\UserCredential;
use Illuminate\Support\Facades\Hash;
use PDOException;

class AuthService
{

    public function CredentialExists(string $email): bool
    {
        try 
        {
            $exists = UserCredential::where('email', $email)->exists();
        } 
        catch (PDOException $e) 
        {
            throw new PDOException('Error en la base de datos');
        }

        return $exists;
    }

    /**
     * Creates a UserCredential Model`s instance
     *
     * @param string $email
     * @param string $password not a hash
     * @return UserCredential
     */
    public function CreateUserCredential(UserAccessData $userAccessData): UserCredential
    {
        $userCredentials = new UserCredential();

        $userCredentials->email = $userAccessData->getEmail();
        $userCredentials->password = Hash::make($userAccessData->getPassword());

        return $userCredentials;
    }

    /**
     * Saves a UserCredential Model`s instance
     *
     * @param Request $request
     * @return MyReponse 
     */
    public function SaveUserCredential(UserAccessData $userAccessData): MyResponse
    {
        $myResponse = new MyResponse(new MyStatus(false, 'El mail ingresado ya existe'));

        try 
        {
            if (!$this->CredentialExists($userAccessData->getEmail())) 
            {
                $userCredentials = $this->CreateUserCredential($userAccessData);

                if($userCredentials->save())
                {
                    $myResponse->getStatus()->setSuccess(true);
                    $myResponse->getStatus()->setMessage('Credenciales creadas exitosamente');
                    $myResponse->data = $userCredentials;
                }           
            } 
        } 
        catch (\PDOException $e) 
        {
            throw $e;
        }

        return $myResponse;
    }
}
