@extends('template.template')

@section('content')
<div class="container">
  <table class="table table-hover">
      <thead>
                  <tr>
                    <th>&nbsp;</th>
                    <th>Nombre</th>
                    <th>Archivos</th>
                    <th>Fecha</th>
                 
                  </tr>
      </thead>
      <tbody>
          @foreach($apuntes as $apunte)
                  
                  <tr>
                    <td><a href="{{ route('apuntes.show', $apunte['slug']) }}">ver</a></td>
                    <td>{{$apunte['nombre']}}</td>
                    <td>{{$apunte['archivos']}}</td>
                    <td>{{$apunte['created_at']}}</td>
                  </tr>

           @endforeach
      </tbody>

  </table>
</div>
                 
@endsection
