<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
   return view('welcome');
});

Route::get('/a', function(Request $r)
{
   return 'HOLA';
});//->middleware('web');