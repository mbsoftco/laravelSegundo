@extends('admin/template/admin_template')

@section('content')

@if (count($errors) > 0)
    <!-- Form Error List -->
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-exclamation-circle"></i> Error!</h4>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(!empty(Session::get('flash_message')))
            <!-- Form Error List -->
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Éxito!</h4>
               {{Session::get('flash_message')}}
              </div>
@endif

<form method="post" action="{{route('usuarios.update', $user->id)}}">
  @csrf
  <input type="hidden" name="_method" value="put" />
  <div class="form-group">
     <label for="nombre">Nombre</label>
     <input class="form-control" id="nombre" name="nombre" type="text" value="{{$user->nombre}}" />
  </div>
  <div class="form-group">
     <label for="email">Correo</label>
     <input class="form-control" id="email" name="email" disabled="true"  type="email" value="{{$user->email}}" />
  </div>
  <div class="form-group">
     <label for="universidad_id">Universidad</label>
     <select class="form-control" id="universidad_id" name="universidad_id" >
         @foreach ($universidades as $u)
            <option value="{{ $u->id }}" {{ $u->id==$user->universidad_id?'selected="selected"':'' }}>{{ $u->nombre }}</option>
         @endforeach      
     </select>
  </div>
  <div class="form-group">
     <a class="btn btn-default" data-toggle="modal" data-target="#modalPassword">Cambiar Contraseña</a>
  </div>
  <button type="submit" class="btn btn-primary">Guardar</button>
  <a class="btn btn-default" href={{route("usuarios.index")}}>Regresar</a>
</form>
<!-- Modal -->
<div id="modalPassword" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cambiar contraseña</h4>
      </div>
      <div class="modal-body">
         <form method="post" action="{{route('usuarios.index')}}">
          @csrf
          <div class="form-group">
             <label for="password">Nueva Contraseña</label>
             <input class="form-control" id="password" name="password" type="password" />
          </div>
          <div class="form-group">
             <label for="password2">Confirma Contraseña</label>
             <input class="form-control" id="password2" type="password" />
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection