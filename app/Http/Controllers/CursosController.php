<?php

namespace App\Http\Controllers;

use App\Curso;

class CursosController extends Controller
{

    public function listJson()
    {
    
       // $user = auth()->user();

        $cursos = Curso::get();
        return response()->json( $cursos, 201);

    }


}
