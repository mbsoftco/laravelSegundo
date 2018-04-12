@extends('template.template')

@section('content')


  <div class="form-group">
     <label for="nombre">Nombre</label>
    {{$apunte->nombre}}
  </div>
  <div class="form-group">
     <label for="tipo">Tipo</label>
     {{$apunte->tipo}}
  </div>
  <div class="form-group">
     <label for="ciclo">Ciclo </label>
     {{$apunte->ciclo}}
  </div>
  <div class="form-group">
     <label for="docente">Docente</label>
     {{$apunte->docente}}
  </div>
      @if($user = Auth::user())

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

      @else


        <div class="form-group">
           <label for="archivo">Archivos</label>

                 {{$apunte->archivos}}
           
        </div>

      @endif


  <div class="form-group">
     <label for="curso_id">Curso</label>
     {{ $apunte->curso()->first()->nombre }}
  </div>
  <div class="form-group">
     <label for="descripcion">Descripción</label>
    {{$apunte->descripcion}}

  </div>


  <div class="apunte-reacciones"><span class="qapunteok">{{$apunte->positivos}}</span> <a href="#" class="apunteok" refid="{{$apunte->id}}">Me gusta</a> <span class="qapunteko">{{$apunte->negativos}}</span> <a href="#" class="apunteko" refid="{{$apunte->id}}">No me gusta</a></div>

  <div>Comentarios</div>
  <div id="apunteComentariosLista" refid="{{$apunte->id}}">
 

  </div>

  
      @if($user = Auth::user())
  <div>

    <form method="post" id="formApunteComentarios" action="{{route('apunte.comentarios.store', $apunte->id)}}">
      @csrf
     <div class="form-group">
     <textarea class="form-control" id="texto" name="texto" type="text" placeholder="Comentar..."  ></textarea>
    </div>   
    <input type="submit" name="" value="Envía" />
    </form>

  </div>

      @endif

                               
@endsection
