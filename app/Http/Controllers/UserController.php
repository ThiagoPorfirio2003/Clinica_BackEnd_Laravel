<?php

namespace App\Http\Controllers;

use App\Entities\Credentials\NewUserCredentialDTO;
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
/*
        //En vez de ->input() preferiria usar ->post() pero no hay una forma de convinar ->post con metodo
        //como ->date() ->enum() ->only


        //return Auth::check($request->password, '$2y$12$7bjLRj4fMnPlJS4cS8AWkuNGqCRC4i/xpKHgkFgxHru0z4zqvpzT2');

        $miRetorno['input'] = $request->post();

        $miRetorno['email'] = $request->post('email');
        $miRetorno['password'] = $request->post('password');
        $miRetorno['hash'] = $this->userCredentialsService->hashPassword($miRetorno['password']);
        $miRetorno['rehash'] = Hash::needsRehash($miRetorno['hash']);

        $miRetorno['validacion'] = Hash::check($miRetorno['password'], $miRetorno['hash']);

        $newUserCredentialDTO = new NewUserCredentialDTO($request['email'], $miRetorno['hash']);

        $modelo = $newUserCredentialDTO->toModel();

        $miRetorno['model'] = $modelo;

        $modelo->save();

        //$miRetorno['db_model'] = UserCredentialModel::where('pass_hash', $miRetorno['hash'])->get();
        $miRetorno['db_model'] = UserCredentialModel::where('email', $miRetorno['email'])->get();


        //$miRetorno['newValidation'] = $miRetorno['hash'] === $miRetorno['db_model']->pass_hash;

        $miRetorno['can_login'] = Auth::attempt(['email' => $miRetorno['email'], 'password' => $miRetorno['password']]);

        return new Response($miRetorno);*/

        $newUserCredentialDTO = new NewUserCredentialDTO($validatedData['email'],
        $this->userCredentialsService->hashPassword($validatedData['password']));

        $userRole = UserRoles::fromInt((int) $validatedData['role']);

        $newUserProfileDTO = new newUserProfileDTO(
            $request->post('name'),
            $request->post('surname'),
            new Carbon($request->post('birthdate')),
            $request->post('dni'),
            array_key_exists('isEnabled', $validatedData) ? $validatedData['isEnabled'] : $userRole == UserRoles::PACIENT
            /* || isEnable si es que este atributo existe y el usuario que realizo la 
            request es administrador*/,
            $userRole,
            $request->file('img'),
        );

        $userCredentialModel = $newUserCredentialDTO->toModel();

        try
        {
            if($userCredentialModel->save())
            {
                //$profileImgName = $this->storageService->defineFileName($userCredentialModel->id . '_0', $newUserProfileDTO->img);
                $profileImgName = $this->storageService->createFileName($newUserProfileDTO->img->extension());

                //Debo agregar algo para cuando son varias fotos
                $newUserProfileModel = $newUserProfileDTO->toModel($userCredentialModel->id, $profileImgName);

                if($newUserProfileModel->save())
                {
                    $registerStatus = $this->storageService->saveUserAvatar($newUserProfileModel->id, $newUserProfileDTO->img, $profileImgName)->myHTTPStatus;

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
