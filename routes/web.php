<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

/*
Route::get('/a', function(Request $r)
{
   return 'HOLA';
});//->middleware('web');
*/
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);

Route::post('/login', function (Request $request) {

    if(Auth::attempt(['email'=> $request->email, 'password'=> $request->password]))
    {

        return 'EXITOS';
    }
    else
    {
        return "fracasos";
    }
});