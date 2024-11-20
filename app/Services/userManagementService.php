<?php

namespace App\Services\User;

class UserManagementService
{

    /*
    No se si sera util

    public function exists(string $email): bool
    {
        try 
        {
            $exists = UserCredential::where('email', $email)->exists();
        } 
        catch (\PDOException $e) 
        {
            throw new \PDOException('Error en la base de datos');
        }

        return $exists;
    }

    public function create( $userAccessData): UserCredential
    {
        $userCredentials = new UserCredential();

        $userCredentials->email = $userAccessData->email;
        $userCredentials->password = Hash::make($userAccessData->password);

        return $userCredentials;
    }
    */

    /*
    public function save(UserAccessDTO $userAccessData) : UserCredentialsReturnDTO
    {
        $userCredentials = null;
        $operationStatus = MyHTTPStatus::createStatusServerError();

        try 
        {
            $userCredentials = $this->create($userAccessData);

            if($userCredentials->save())
            {
                $operationStatus->changeStatusToCreated('Credenciales creadas exitosamente');
            }
            else
            {
                $userCredentials = null;
            }  
        } 
        catch (\PDOException $e) 
        {
            $operationStatus->changeStatusToServerError($e->getMessage());
        }

        return new UserCredentialsReturnDTO($operationStatus, $userCredentials);
    }
    */
}
