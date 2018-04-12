@extends('layouts.nootas')

@section('searchRegistro')
	 <input type="search" class="form-control" placeholder="Busca notas, apuntes, exámenes, monografías de tu universidad">
@endsection

@section('formLoginRegistro')
	<form class="form-inline">
		<div class="form-group">
			<input type="text" class="form-control margin data_usuario" placeholder="Correo electrónico" required="required">
		</div>
		<div class="form-group">
			<input type="password" class="form-control margin data_usuario" placeholder="Contraseña" required="required">
		</div>
		<button type="submit" class="btn btn-default margin">Iniciar sesión</button>
		<a href="#" class="margin link_recovery">Olvidaste tu cuenta?</a>
	</form>
@endsection

@section('content')
<link href="{{ asset('css/registro.css') }}" type="text/css" rel="stylesheet">

<section id="app_registro">
	<div id="registro">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="container_title">
						<h1>Bienvenido a Nootas.com</h1>
						<h3>Conéctate con tus compañeros y obtén ayuda en tiempo real de estudiantes expertos y encuentra miles de notas, exámenes y trabajos finales de los cursos de tu universidad.</h3>
					</div>
				</div>
				<div class="col-md-6">
					<div class="create-acount">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title"><span class="black">Nuevo en Nootas?</span> Regístrate, es gratis!</h4>
							</div>
							<div class="panel-body">
								@isset($alreadyExists)
									<div class="alert alert-danger" role="alert">El usuario ya está registrado</div>
								@endisset
								<form class="form" id="frmNuevoRegistro">
									<div class="form-group">
										<input type="text" class="form-control" name="txtNombres" id="txtNombres" placeholder="Nombre" required="required">
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="txtApellidos" id="txtApellidos" placeholder="Apellidos" required="required">
									</div>
									<div class="form-group">
										<input type="email" class="form-control" name="txtCorreo" id="txtCorreo" placeholder="Correo electrónico" required="required">
										<span class="msj_alert cl_green" id="mail_msj_ok">La direccón de correo es válida</span>
										<span class="msj_alert cl_red" id="mail_msj_error">La direccón de correo no es válida</span>
									</div>
									<div class="form-group">
										<input type="password" class="form-control" name="txtClave" id="txtClave" placeholder="Contraseña (6 o más caracteres)" required="required" minlength="6">
										<span class="msj_alert cl_green" id="clave_msj_ok">Clave correcta</span>
										<span class="msj_alert cl_red" id="clave_msj_error">La clave debe tener 6 o más caracteres</span>
									</div>
									<div class="form-group botonera">
										<button type="submit" class="btn btn-default btnNootas btnRegistro">Crear cuenta</button>
									</div>
								</form>
							</div>
							<div class="panel-footer">
								<div class="form-group botonera">
									<a href="{{ route('registro.social', 'facebook') }}" class="btn btn-default margin btnNootas btnLoginFacebook btnSocial"> <span></span> INGRESA CON FACEBOOK</a>
									<a href="{{ route('registro.social', 'google') }}" class="btn btn-default margin btnNootas btnLoginGoogle btnSocial"> <span></span> INGRESA CON GOOGLE</a>
								</div>
								<p>Al crear una cuenta, estás de acuerdo con los términos y condiciones de Nootas.com.</p>
							</div>
						</div>
					</div>  
				</div>
			</div>
		</div>
		<footer>
			<nav>
				<ul>
					<li><a href="#">Qué es Nootas</a></li>
					<li><a href="#">Sobre nosotros</a></li>
					<li><a href="#">Términos y condiciones</a></li>
					<li><a href="#">Política de privacidad</a></li>
					<li><a href="#">Blog</a></li>
					<li><a href="#">&copy; 2017 Nootas</a></li>
				</ul>
			</nav>
		</footer>
	</div>
</section>
@endsection

@section('scriptsInclude')
	<script src="{{ asset("/bower_components/jquery/dist/jquery.min.js") }}"></script>
	<script src="{{ asset('js/Registro.js') }}"></script>
@endsection