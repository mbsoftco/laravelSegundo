<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Registro extends Model
{
	//
	public Function getUniversidades()
	{
		$universidades = DB::table('universidades')->select('id', 'nombre', 'nombre_corto')->get();
		return $universidades;
	}
	public Function getCursos($universidad)
	{
		$univ=explode(' - ', $universidad)[0];
		$idUniversidad = DB::table('universidades')->select('id')->where('nombre_corto', '=', $univ)->get();
		$idUniversidad=$idUniversidad[0]->id;
		$cursos = DB::table('cursos')->select('id', 'nombre')->where('universidad_id', '=', $idUniversidad)->get();
		return $cursos;
	}
	public Function GetCarrera($universidad)
	{
		$univ=explode(' - ', $universidad)[0];
		$idUniversidad = DB::table('universidades')->select('id')->where('nombre_corto', '=', $univ)->get();
		$idUniversidad=$idUniversidad[0]->id;
		$carreras = DB::table('carreras')->select('id', 'nombre')->where('universidad_id', '=', $idUniversidad)->get();
		return $carreras;
	}
}
