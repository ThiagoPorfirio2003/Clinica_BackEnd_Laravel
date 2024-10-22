<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private $authService;

    public function __construct(        
        AuthService $authService)
    {
      $this->authService = $authService;
    }

    public function create(Request $request) : Response
    {
        $modelo = $this->authService->CreateCredentials($request);

        return response(['Modelo'=> $modelo, 'ALL' => $request->all()]);
    }
}
