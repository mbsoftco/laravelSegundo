<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class UsersController extends Controller
{


    public function getUser()
    {
    
        $user = auth()->user();

        return response()->json( $user, 201);
    }  



    public function logout()
    {
        Auth::logout();
        Session::flush();
       // $respuesta = {"data": 1};
       // return response()->json($respuesta , 201);
    }

}
