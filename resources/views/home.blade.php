<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nootas</title>
    <!-- Styles -->
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">

  </head>
  <body>

    
  <div id="home-container"></div>
  <div id="modal-container"></div>


    <script src="{{ asset("/js/home.js") }}"></script>
  </body>
</html>
