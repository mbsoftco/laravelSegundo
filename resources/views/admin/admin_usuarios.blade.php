@extends('admin/template/admin_template')

@section('content')


@if(!empty(Session::get('flash_message')))
            <!-- Form Error List -->
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Éxito!</h4>
               {{Session::get('flash_message')}}
              </div>
@endif
<div class="mb-box mb-corner">
  <div class="row">
  <div class="col-md-3">
    <a href="{{route("usuarios.create")}}" class="btn btn-default">Agregar</a>
  </div>
  <div class="col-md-9 text-right">
  {{ $users->links() }}
  </div>
  </div>
  <table class="table table-hover">
      <thead>
                  <tr>
                    <th>&nbsp;</th>
                    <th>Nombre <a href="{{route("usuarios.index", ["users.nombre", (($order_field=="users.nombre")?($order_direction=="asc"?"desc":"asc"):"asc")])}}" class="pull-right"><i class="menu-icon fa fa-sort"></i></a></th>
                    <th>Correo <a href="{{route("usuarios.index", ["users.email", (($order_field=="users.email")?($order_direction=="asc"?"desc":"asc"):"asc")])}}" class="pull-right"><i class="menu-icon fa fa-sort"></i></a></th>
                    <th>Fecha <a href="{{route("usuarios.index", ["users.created_at", (($order_field=="users.created_at")?($order_direction=="asc"?"desc":"asc"):"asc")])}}" class="pull-right"><i class="menu-icon fa fa-sort"></i></a></th>
                    <th>Universidad <a href="{{route("usuarios.index", ["universidades.nombre", (($order_field=="universidades.nombre")?($order_direction=="asc"?"desc":"asc"):"asc")])}}" class="pull-right"><i class="menu-icon fa fa-sort"></i></a></th>
                  </tr>
      </thead>
      <tbody>
          @foreach($users as $user)
                  
                  <tr>
                    <td><a href="{{ route('usuarios.edit', $user['id']) }}"><i class="menu-icon fa fa-edit"></i></a> <a class="btn-elimina" href="#" ref="{{ $user['id'] }}"><i class="menu-icon fa fa-trash"></i></a><form action="{{ route('usuarios.destroy', $user['id']) }}" id="delete{{ $user['id'] }}" method="post">@csrf<input type="hidden" name="_method" value="delete" /></form></td>
                    <td>{{$user['nombre']}}</td>
                    <td>{{$user['email']}}</td>
                    <td>{{$user['created_at']}}</td>
                    <td>{{$user['unombre']}}</td>
                  </tr>

           @endforeach
      </tbody>

  </table>
  <div class="row">
  <div class="col-md-3">
    <a href="{{route("usuarios.create")}}" class="btn btn-default">Agregar</a>
  </div>
  <div class="col-md-9 text-right">
  {{ $users->links() }}
  </div>
  </div>
</div>
<script type="text/javascript">
  
  $(document).ready(function(){

    $(".btn-elimina").click(function(e){

        e.preventDefault();

        $("#delete" + $(this).attr("ref") ).submit();


    });



  });

</script>
@endsection