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


<form method="post" action="{{route('cursos.update', $curso->id)}}">
  @csrf
  <input type="hidden" name="_method" value="put" />
  <div class="form-group">
     <label for="nombre">Nombre</label>
     <input class="form-control" id="nombre" name="nombre" type="text" value="{{$curso->nombre}}" />
  </div>
  <div class="form-group">
     <label for="slug">Slug</label>
     <input class="form-control" id="slug" name="slug" type="text" value="{{$curso->slug}}" />
  </div>
  <div class="form-group">
     <label for="universidad_id">Universidad</label>
     <select class="form-control" id="universidad_id" name="universidad_id" >
         @foreach ($universidades as $u)
            <option value="{{ $u->id }}" {{ $u->id==$curso->universidad_id?'selected="selected"':'' }}>{{ $u->nombre }}</option>
         @endforeach      
     </select>
  </div>
  <button type="submit" class="btn btn-primary">Guardar</button>
  <a class="btn btn-default" href={{route("cursos.index")}}>Regresar</a>
</form>
@endsection