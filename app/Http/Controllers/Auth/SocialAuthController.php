<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialAuthController extends Controller
{
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
            return $this->authAndRedirect($user); // Login y redirección
        } else {  
            // En caso de que no exista creamos un nuevo usuario con sus datos.

            if($provider=="google"){
	            $user = User::create([
	                'nombre' => $social_user->user['name']['givenName'],
	                'apellido' => $social_user->user['name']['familyName'],
	                'email' => $social_user->email,
	                //'avatar' => $social_user->avatar,
	            ]);

            }else if($provider=="facebook"){

	            $user = User::create([
	                'nombre' => $social_user->user['first_name'],
	                'apellido' => $social_user->user['last_name'],
	                'email' => $social_user->email,
	                //'avatar' => $social_user->avatar,
	            ]);
            	
            }
 
            return $this->authAndRedirect($user); // Login y redirección
        }
    }
 
    // Login y redirección
    public function authAndRedirect($user)
    {
        Auth::login($user);
 
        return redirect()->to('/');
    }
}
