<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConfigController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getApunteTiposJson()
    {
        return response()->json(config("admin.apunte_tipos"));
    }  
  
    public function getCiclosJson()
    {
        $ciclos = [];
         for($i=date("Y");$i>=date("Y")-5; $i--){

            $ciclos[] = $i . ' - 0';
            $ciclos[] = $i . ' - 1';
            $ciclos[] = $i . ' - 2';

         }   

        return response()->json($ciclos);
    }  
  

}
