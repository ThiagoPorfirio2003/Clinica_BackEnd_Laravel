<?php

namespace App\Http\Controllers;

use App\Entities\Credentials\NewUserCredentialDTO;
use App\Entities\Users\Patient\BasePatientDTO;
use App\Entities\Users\Profile\newUserProfileDTO;
use App\Entities\Users\UserRoles;
use App\Http\Requests\userRegisterRequest;
use App\Services\Credentials\UserCredentialService;
use App\Services\StorageService;
use App\Support\Status\MyHTTPStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function __construct(        
        private UserCredentialService $userCredentialsService,
        private StorageService $storageService)
//        private UserProfileService $userService)
    {}

    public function register(userRegisterRequest $request) : JsonResponse
    {
        $registerStatus = MyHTTPStatus::createStatusServerError();

        $validatedData = $request->validated();

        $newUserCredentialDTO = new NewUserCredentialDTO($validatedData['email'],
        $this->userCredentialsService->hashPassword($validatedData['password']));

        $userRole = UserRoles::fromInt((int) $validatedData['role']);

        $newUserProfileDTO = new newUserProfileDTO(
            $request->post('name'),
            $request->post('surname'),
            new Carbon($request->post('birthdate')),
            $request->post('dni'),
            array_key_exists('isEnabled', $validatedData) ? $validatedData['isEnabled'] : $userRole == UserRoles::PATIENT,
            $userRole,
            $request->file('img'),
        );

        $userCredentialModel = $newUserCredentialDTO->toModel();

        try
        {
            if($userCredentialModel->save())
            {
                $profileImgName = $this->storageService->createFileName($newUserProfileDTO->img->extension());
                $newUserProfileModel = $newUserProfileDTO->toModel($userCredentialModel->id, $profileImgName);

                if($newUserProfileModel->save())
                {
                    $registerStatus = $this->storageService->saveUserAvatar($newUserProfileModel->id, $newUserProfileDTO->img, $profileImgName)->myHTTPStatus;

                    if($registerStatus->status == 201)
                    {
                        //Me falta agregar crear patient, doctor, administrador

                        $registerStatus->message = 'Usuario creado exitosamente';

                        switch($newUserProfileDTO->role)
                        {
                            /*
                            case UserRoles::PATIENT:
                                $patientModel = BasePatientDTO::fromArray($validatedData)->toModel($newUserProfileModel->id);

                                if(!$patientModel->save())
                                {
                                    $registerStatus->message = 'La informacion del paciente no pudo ser guardada';
                                }
                                break;
                            */
                        }
                    }
                    else
                    {
                        $registerStatus->message = 'La foto del usuario no pudo ser guardada';
                    }
                }
                else
                {
                    $registerStatus->message = 'Hubo un error durante el guardado del perfil';
                }
            }
            else
            {
                $registerStatus->message = 'Hubo un error durante el guardado de las credenciales';
            }
        }   
        catch(\PDOException $e)
        {
           $registerStatus->changeStatusToServerError($e->getMessage());
        }

        return response()->json($registerStatus, $registerStatus->status);
        //return response()->json($request->allFiles());
    }
}
