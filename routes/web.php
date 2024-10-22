<?php

use App\Models\UserCredential;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
   return view('welcome');
});

Route::get('/a', function(Request $r)
{
   return 'HOLA';
});//->middleware('web');

Route::post('/register', function(Request $r)
{
   $newAuthData = new UserCredential();

   $newAuthData->email = $r->email;
   $newAuthData->password = Hash::make($r->password);

   $newAuthData->fill($r->all());

   $estado = $newAuthData->save();


   return ['a'=> 'HOLA', 'Estado'=> $estado, 'ALL' => $r->all()];
});//->middleware('web');