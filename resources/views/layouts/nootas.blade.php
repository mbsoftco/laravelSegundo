<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div id="app">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="left">
					<div class="navbar-left" id="menu-search">
						<a class="navbar-brand" href="#">
							<img alt="Brand" src="https://icon-icons.com/icons2/37/PNG/128/glasses_3629.png" >							
						</a>
						@section('searchRegistro')

						@show                       
					</div>
				</div>
				<div class="right">						
					<div class="nav navbar-nav navbar-right" id="menu-login">
						@section('formLoginRegistro')

						@show						
					</div>
				</div>
			</div>
		</nav>		
		<section id="aplication_registro">
			@yield('content')
		</section>
	</div>

	<!-- Scripts -->
	
	<script src="{{ asset('js/app.js') }}"></script>
	@section('scriptsInclude')
			
	@show
</body>
</html>