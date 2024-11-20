<?php

namespace App\Http\Controllers;

use App\Entities\Credentials\NewUserCredentialDTO;
use App\Entities\Users\Profile\newUserProfileDTO;
use App\Entities\Users\UserRoles;
use App\Services\Credentials\UserCredentialService;
use App\Services\StorageService;
use App\Services\UserProfileService;
use App\Support\Status\MyHTTPStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function __construct(        
        private UserCredentialService $userCredentialsService,
        private StorageService $storageService,
        private UserProfileService $userService)
    {}

    public function register(Request $request) : JsonResponse
    {
        $registerStatus = MyHTTPStatus::createStatusServerError();
        /*
        email
        password

        name
        surname
        birthdate
        dni
        isEnabled (Si no viene, por defecto es true)
        role
        profileImg tipo UploadedFile

        Informacion segun el tipo de usuario, puede ser el
        insuranceNumber
        */
        /*
        Validar que los datos cumplan las condiciones
        Validar el/los archivos
        Validar que los datos no pertenezcan a otro usuario (email, dni, numero de obra social, etc) 
        */

        //En vez de ->input() preferiria usar ->post() pero no hay una forma de convinar ->post con metodo
        //como ->date() ->enum() ->only

        $newUserCredentialDTO = new NewUserCredentialDTO($request->post('email'),
        $this->userCredentialsService->hashPassword($request->post('password')));

        $userRole = UserRoles::fromInt((int) $request->post('role'));

        $newUserProfileDTO = new newUserProfileDTO(
            $request->post('name'),
            $request->post('surname'),
            new Carbon($request->post('birthdate')),
            $request->post('dni'),
            $userRole == UserRoles::PACIENT,
            $userRole,
            $request->file('img'),
        );

        /*
            Podria agregar un array con la informacion del tipo de usuario en especifico,
            si es que tiene
        */

        /*
            Quizas aca deba agregar un array cuya informacion debe ser numerica y tiene
            que ser transformada de tipo string a tipo int

            Despues convinar ese array con $registerPost
        */

        $userCredentialModel = $newUserCredentialDTO->toModel();

        try
        {
            if($userCredentialModel->save())
            {
                $profileImgName = $this->storageService->defineFileName($userCredentialModel->id . '_0', $newUserProfileDTO->img);

                //Debo agregar algo para cuando son varias fotos
                $newUserProfileModel = $newUserProfileDTO->toModel($userCredentialModel->id, $profileImgName);

                if($newUserProfileModel->save())
                {
                    $registerStatus = $this->storageService->saveUserAvatar($profileImgName, $newUserProfileDTO->img)->myHTTPStatus;

                    if($registerStatus->status == 201)
                    {
                        $registerStatus->message = 'Usuario creado exitosamente';
                        //Me falta agregar crear patient, doctor, administrador
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
