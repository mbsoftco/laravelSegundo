@extends('layouts.nootas')

@inject('universidades','App\Http\Controllers\RegistroController')

@section('content')
<link href="{{ asset('css/registro.css') }}" type="text/css" rel="stylesheet">
<section id="perfil_registro">
	<div class="container">
		<div class="row">
			<div id="form_perfil_registro">
				<h1>Primero, personalicemos tu perfil</h1>
				<p>Esto nos ayudará a mostrarte información relevante</p>
				<br>
				<form class="form" id="frmRegistroPerfil" method="post">
					<div class="form-group">
						<label for="txtUniversidad">¿En que universidad estas estudiando?</label>
						<input type="text" class="form-control" id="txtUniversidad" name="txtUniversidad" list="listaUniversidades" required="required">
						<datalist id="listaUniversidades">
							@foreach ($universidades->getUniversidades() as $universidad)
								<option value="{{ $universidad->nombre_corto }} - {{ $universidad->nombre }}"></option>
							@endforeach
						</datalist>
					</div>
					<div class="form-group">
						<label for="txtCarrera">¿Que carrera estas estudiando?</label>
						<input type="text" class="form-control" id="txtCarrera" name="txtCarrera" list="listaCarreras" required="required">
						<datalist id="listaCarreras">

						</datalist>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="lstAnioInicio">Año de inicio</label>
								<select name="lstAnioInicio" id="lstAnioInicio" class="form-control" required="required">
									<option value="">[AÑO]</option>
									<option value="2010">2010</option>
									<option value="2011">2011</option>
									<option value="2012">2012</option>
									<option value="2013">2013</option>
									<option value="2014">2014</option>
									<option value="2015">2015</option>
									<option value="2016">2016</option>
									<option value="2017">2017</option>
									<option value="2018">2018</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="lstAnioFin">Año de fin o esperado</label>
								<select name="lstAnioFin" id="lstAnioFin" class="form-control" required="required">
									<option value="">[AÑO]</option>
									<option value="2015">2015</option>
									<option value="2016">2016</option>
									<option value="2017">2017</option>
									<option value="2018">2018</option>
									<option value="2019">2019</option>
									<option value="2020">2020</option>
									<option value="2021">2021</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group botonera">
						<button type="submit" class="btn btn-default btnNootas btnRegistro">Siguiente</button>
					</div>
				</form>
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
</section>
@endsection

@section('scriptsInclude')
	<script src="{{ asset("/bower_components/jquery/dist/jquery.min.js") }}"></script>
	<script src="{{ asset('js/Registro.js') }}"></script>
@endsection