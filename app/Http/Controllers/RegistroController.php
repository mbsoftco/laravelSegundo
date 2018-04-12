<?php

namespace App\Http\Controllers;

use App\User;
use Socialite;
use Illuminate\Support\Collection as Collection;
use App\Registro;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
	//
	public $Registro;

	public function getRegistro()
	{
		return view('registro');
		//return redirect()->route('reg', ['id' => 1]);
	}

	public function RegistrarDatos(Request $request)
	{
		$nombres = $request->input('nombres');
		$apellidos = $request->input('apellidos');
		$correo = $request->input('correo');
		$clave = $request->input('clave');
		session_start();
		$_SESSION["registrado"] = 1;
		$_SESSION["registrado_nombres"] = $nombres;
		$_SESSION["registrado_apellidos"] = $apellidos;
		$_SESSION["registrado_correo"] = $correo;
		$_SESSION["registrado_clave"] = $clave;
		return 1;
	}
	public function getRegistroPerfil()
	{
		$estado = $this->validarLogin();
		if($estado==1){
			return view('registro_perfil');
		}else{
			return redirect('registro');
		}
	}
	// Metodo encargado de la redireccion a Facebook
	public function redirectToProvider($provider)
	{
		if($provider=="google"){
			return Socialite::driver($provider)->redirect();
		}else{
			return Socialite::driver($provider)->fields(['email', 'first_name', 'last_name'])->redirect();
		}
	}
	// Metodo encargado de obtener la información del usuario
	public function handleProviderCallback($provider)
	{
		// Obtenemos los datos del usuario
		$social_user = false; 
		if($provider=="google"){
			$social_user = Socialite::driver($provider)->user(); 
		}else{
			$social_user = Socialite::driver($provider)->fields(['email', 'first_name', 'last_name'])->user(); 
		}
		// Comprobamos si el usuario ya existe
		if ($user = User::where('email', $social_user->email)->first()) {
			return view('registro',['alreadyExists' => 1]);
		}else{
			session_start();
			$_SESSION["registrado"] = 1;
			$_SESSION["registrado_nombres"] = $social_user->first_name;
			$_SESSION["registrado_apellidos"] = $social_user->last_name;
			$_SESSION["registrado_correo"] = $social_user->email;
			return redirect('valida-registro-social');
		}
	}
	public function getValidaRegistroSocial()
	{
		$estado = $this->validarLogin();
		if($estado==1){
			$nombre = $_SESSION["registrado_nombres"];
			$apellidos = $_SESSION["registrado_apellidos"];
			$correo = $_SESSION["registrado_correo"];
			return view('registro_social_valida',['nombre'=>$nombre,'apellidos'=>$apellidos,'correo'=>$correo]);
		}else{
			return redirect('registro');
		}
	}
	public function RegistrarClaveSocial(Request $request)
	{
		$clave = $request->input('clave');
		$_SESSION["registrado_clave"] = $clave;
		return 1;
	}
	public function RegistrarPerfil(Request $request)
	{
		$universidad = $request->input('universidad');
		$carrera = $request->input('carrera');
		$inicio = $request->input('inicio');
		$fin = $request->input('fin');
		session_start();
		$_SESSION["registrado_universidad"] = $universidad;
		$_SESSION["registrado_carrera"] = $carrera;
		$_SESSION["registrado_inicio"] = $inicio;
		$_SESSION["registrado_fin"] = $fin;
		return 1;
	}
	public function getRegistroCursos()
	{
		$estado = $this->validarLogin();
		if($estado==1){
			$universidad = $_SESSION["registrado_universidad"];
			$this->Registro=new Registro;
			$cursos = $this->Registro->getCursos($universidad);
			return view('registro_cursos',['cursos' => $cursos ]);
		}else{
			return redirect('registro');
		}
	}
	public function RegistrarCursos(Request $request)
	{
		$cursos = $request->input('cursos');
		//Envío completo de datos
		session_start();
		$data=array();
		$obj = new \stdClass();
		$obj->nombres=$_SESSION["registrado_nombres"];
		$obj->apellidos=$_SESSION["registrado_apellidos"];
		$obj->correo=$_SESSION["registrado_correo"];
		$obj->clave=$_SESSION["registrado_clave"];
		$obj->universidad=$_SESSION["registrado_universidad"];
		$obj->carrera=$_SESSION["registrado_carrera"];
		$obj->inicio=$_SESSION["registrado_inicio"];
		$obj->fin=$_SESSION["registrado_fin"];
		$datosCursos=array();
		foreach ($cursos as $curso) {
			if($curso != null){
				$datosCursos[]=$curso;
			}
		}
		$obj->cursos=$datosCursos;
		$collection = Collection::make($obj);
		$data[]=$collection;
		return $data;
	}

	public function getUniversidades()
	{
		$this->Registro=new Registro;
		$universidades = $this->Registro->getUniversidades();
		return $universidades;
	}
	public function GetCarrera(Request $request)
	{
		$universidad = $request->input('universidad');
		$this->Registro=new Registro;
		$carreras = $this->Registro->GetCarrera($universidad);
		return $carreras;
	}
	public function validarLogin()
	{
		session_start();
		if(isset($_SESSION["registrado"])){
			$estado = $_SESSION["registrado"];
		}else{
			$estado = 0;
		}
		return $estado;
	}
	public function terminar_sesiones()
	{
		session_start();
		$status=session_destroy();
		if($status){
			return redirect('registro');
		}
	}
}