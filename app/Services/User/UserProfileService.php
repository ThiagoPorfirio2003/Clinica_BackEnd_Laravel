<?php

namespace App\Services\User;

use App\Entities\Users\Profile\UserProfileModel;

class UserProfileService{
    
    public function dniExists(int $dni) : bool
    {
        return UserProfileModel::where('dni', $dni)->exists();
    }

    /*
    No se si sera util
    
    public function exists(int $dni) : bool
    {
        try 
        {
            $exists = UserProfile::where('dni', $dni)->exists();
        } 
        catch (\PDOException $e) 
        {
            throw new \PDOException('Error en la base de datos');
        }

        return $exists;
    }

    public function create(BaseUserDTO $baseUserData) : UserProfile
    {
        $user = new UserProfile();

        $user->credential_id = $baseUserData->credentialId;
        $user->name = $baseUserData->name;
        $user->surname = $baseUserData->surname;
        $user->birthdate = $baseUserData->birthdate;
        $user->dni = $baseUserData->dni;
        $user->is_enabled = $baseUserData->isEnabled;
        $user->role = $baseUserData->role->label();
        $user->profile_img_url = $baseUserData->profileImgUrl;

        return $user;
    }
    */

    /*
    public function save(BaseUserDTO $baseUserData) : UserReturnDTO
    {
        $user = null;
        $operationStatus = MyHTTPStatus::createStatusServerError();

        try 
        {
            $user = $this->create($baseUserData);

            if($user->save())
            {
                $operationStatus->changeStatusToCreated('Usuario creado exitosamente');
            }
            else
            {
                $user = null;
            }  
        } 
        catch (\PDOException $e) 
        {
            throw $e;
        }

        return new UserReturnDTO($operationStatus, $user);
    }
    */
}
