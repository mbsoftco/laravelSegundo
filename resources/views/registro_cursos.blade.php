@extends('layouts.nootas')

@section('content')
<link href="{{ asset('css/registro.css') }}" type="text/css" rel="stylesheet">
<section id="cursos_registro">
	<div class="container">
		<div class="row">
			<div id="form_perfil_registro">
				<h1>Ya casi terminas...</h1>
				<p>Esto nos ayudará a mostrarte información relevante</p>
				<br>
				<form class="form" id="fmrCursos">
					<div class="form-group">
						<label>¿Que cursos estas llevando ahora?</label>
						<input type="text" class="form-control mb_10 filters_cursos" list="listaCursos" id=="filtro_curso_1">
						<input type="text" class="form-control mb_10 filters_cursos" list="listaCursos" id=="filtro_curso_2">
						<input type="text" class="form-control mb_10 filters_cursos" list="listaCursos" id=="filtro_curso_3">
						<input type="text" class="form-control mb_10 filters_cursos" list="listaCursos" id=="filtro_curso_4">
						<input type="text" class="form-control mb_10 filters_cursos" list="listaCursos" id=="filtro_curso_5">
						<datalist id="listaCursos">
							@foreach ($cursos as $curso)
								<option value="{{ $curso->nombre }}"></option>
							@endforeach
						</datalist>
					</div>
					<div class="form-group rightAlign">
						<a href="#" class="" id="agregarCursos">Agregar más cursos</a>
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