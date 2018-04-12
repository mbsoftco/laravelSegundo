@extends('template.template')

@section('content')
<div class="container">
  <table class="table table-hover">
      <thead>
                  <tr>
                    <th>&nbsp;</th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                 
                  </tr>
      </thead>
      <tbody>
          @foreach($apuntes as $apunte)
                  
                  <tr>
                    <td><a href="{{ route('misapuntes.edit', $apunte['id']) }}">edita</a> <a class="btn-elimina" href="#" ref="{{ $apunte['id'] }}">elimina</a><form action="{{ route('misapuntes.delete', $apunte['id']) }}" id="delete{{ $apunte['id'] }}" method="post">@csrf<input type="hidden" name="_method" value="delete" /></form></td>
                    <td>{{$apunte['nombre']}}</td>
                    <td>{{$apunte['created_at']}}</td>
                  </tr>

           @endforeach
      </tbody>

  </table>
</div>
                 
@endsection
