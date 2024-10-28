<?php

namespace App\Http\Controllers;

use App\Classes\MyResponse;
use App\Classes\MyStatus;
use App\Classes\UserAccessData;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PDOException;

class UserController extends Controller
{
    public function __construct(        
        private AuthService $authService)
    {}

    public function save(Request $request) : Response
    {
        $operationStatus = new MyStatus(false, '');
        //$retorno = $request->all();

        //$userAccessData = new UserAccessData($request->email, $request->password);

        try
        {
            $userCredentialReponse = $this->authService->SaveUserCredential(new UserAccessData($request->email, $request->password));

            if($userCredentialReponse->getStatus())
            {

            }
        }   
        catch(PDOException $e)
        {
           $operationStatus->setMessage($e->getMessage());
        }


        return response($operationStatus);
    }
}
