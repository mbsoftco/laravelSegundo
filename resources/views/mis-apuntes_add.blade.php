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



<form method="post" action="{{route('misapuntes.store')}}" enctype="multipart/form-data">
  @csrf
  <div class="form-group">
     <label for="nombre">Nombre</label>
     <input class="form-control" id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" />
  </div>
  <div class="form-group">
     <label for="tipo">Tipo</label>
     <select class="form-control" id="tipo" name="tipo" type="text">
         @foreach (config("admin.apunte_tipos") as $t)

          @if (old('tipo')==$t)
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


          @if (old('ciclo')=='II  - '.$i)
            <option value="{{ 'II  - '.$i }}" selected="selected">{{ 'II  - '.$i }}</option>
            @else
             <option value="{{ 'II  - '.$i }}">{{ 'II  - '.$i }}</option>
          @endif  
   
          @if (old('ciclo')=='I  - '.$i)
            <option value="{{ 'I  - '.$i }}" selected="selected">{{ 'I  - '.$i }}</option>
            @else
             <option value="{{ 'I  - '.$i }}">{{ 'I  - '.$i }}</option>
          @endif  
         @endfor
     
     </select>
  </div>
  <div class="form-group">
     <label for="docente">Docente</label>
     <input class="form-control" id="docente" name="docente" type="text" value="{{ old('docente') }}" />
  </div>
  <div class="form-group">
     <label for="universidad_id">Curso</label>
     <select class="form-control" id="curso_id" name="curso_id" >
         @foreach ($cursos as $c)

          @if (old('curso_id')==$c->id)
            <option value="{{ $c->id }}" selected="selected">{{ $c->nombre }}</option>
            @else
             <option value="{{ $c->id }}">{{ $c->nombre }}</option>
          @endif      
         @endforeach      
     </select>
  </div>
  <div class="form-group">
     <label for="descripcion">Descripción</label>
     <textarea class="form-control" id="descripcion" name="descripcion" type="text"  >{{ old('descripcion') }}</textarea>
  </div>
  <div class="form-group">
     <label for="archivo">Archivo</label>
     <input class="form-control" id="archivo" name="archivo" type="file" accept=".jpg,.png,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf" />
  </div>
  <div class="form-group">
     <label for="archivo">Imágenes</label>
     <input class="form-control" id="imagen" name="imagen[]" type="file" multiple="true" accept=".jpg,.png" />
  </div>



     
  <button type="submit" class="btn btn-primary">Guardar</button>
  <a class="btn btn-default" href={{route("misapuntes.index")}}>Regresar</a>
</form>
                               
@endsection
