@extends('template.template')

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



<form method="post" action="{{route('misapuntes.update', $apunte->id)}}" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="_method" value="put" />
  <div class="form-group">
     <label for="nombre">Nombre</label>
     <input class="form-control" id="nombre" name="nombre" type="text" value="{{$apunte->nombre}}" />
  </div>
  <div class="form-group">
     <label for="tipo">Tipo</label>
     <select class="form-control" id="tipo" name="tipo" type="text">
         @foreach (config("admin.apunte_tipos") as $t)

          @if ($apunte->tipo==$t)
            <option value="{{ $t }}" selected="selected">{{ $t }}</option>
            @else
             <option value="{{ $t }}">{{ $t }}</option>
          @endif      
         @endforeach 
       
     </select>
  </div>
  <div class="form-group">
     <label for="ciclo">Ciclo</label>
     <select class="form-control" id="ciclo" name="ciclo" type="text">
         @for ($i=date("Y");$i>=date("Y")-5; $i--)


          @if ($apunte->ciclo=='II  - '.$i)
            <option value="{{ 'II  - '.$i }}" selected="selected">{{ 'II  - '.$i }}</option>
            @else
             <option value="{{ 'II  - '.$i }}">{{ 'II  - '.$i }}</option>
          @endif  
   
          @if ($apunte->ciclo=='I  - '.$i)
            <option value="{{ 'I  - '.$i }}" selected="selected">{{ 'I  - '.$i }}</option>
            @else
             <option value="{{ 'I  - '.$i }}">{{ 'I  - '.$i }}</option>
          @endif  
         @endfor
     
     </select>
  </div>
  <div class="form-group">
     <label for="docente">Docente</label>
     <input class="form-control" id="docente" name="docente" type="text" value="{{$apunte->docente}}" />
  </div>
  <div class="form-group">
     <label for="archivo">Archivo</label>

            @foreach ($archivos as $archivo)
            @if (strpos($archivo->tipo, "image")===false)
            <iframe src="{{ Helper::getPdf($archivo, $token) }}" width="100%" height="600"></iframe>

            @else
            <div class="no-context viewer" style="background-image:url('{{Helper::getImage($archivo)}}');">
            
            </div>
            @endif
            @endforeach
     
  </div>
  <div class="form-group">
     <label for="curso_id">Curso</label>
     <select class="form-control" id="curso_id" name="curso_id" >
         @foreach ($cursos as $u)
            <option value="{{ $u->id }}" {{ $u->id==$apunte->curso_id?'selected="selected"':'' }}>{{ $u->nombre }}</option>
         @endforeach      
     </select>
  </div>
  <div class="form-group">
     <label for="descripcion">Descripción</label>
     <textarea class="form-control" id="descripcion" name="descripcion" type="text"  >{{$apunte->descripcion}}</textarea>
  </div>

  <button type="submit" class="btn btn-primary">Guardar</button>
  <a class="btn btn-default" href={{route("misapuntes.index")}}>Regresar</a>
</form>
                               
@endsection
