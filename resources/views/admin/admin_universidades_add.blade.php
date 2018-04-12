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



<form method="post" action="{{route('universidades.store')}}">
  @csrf
  <div class="form-group">
     <label for="nombre">Nombre</label>
     <input class="form-control" id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" />
  </div>
  <div class="form-group">
     <label for="nombre_corto">Nombre Corto</label>
     <input class="form-control" id="nombre_corto" name="nombre_corto" type="text" value="{{ old('nombre_corto') }}" />
  </div>
  <button type="submit" class="btn btn-primary">Guardar</button>
  <a class="btn btn-default" href={{route("universidades.index")}}>Regresar</a>
</form>

@endsection