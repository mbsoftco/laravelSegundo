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
     <select class="form-control universidad_id" >
         @foreach ($universidades as $u)
            <option value="{{ $u->id }}"  {{ $u->id==$universidad_id?'selected="selected"':'' }}>{{ $u->nombre }}</option>
         @endforeach      
     </select>
  </div>
  <div class="col-md-3">
    <a href="{{route("cursos.create")}}" class="btn btn-default">Agregar</a>
  </div>
  <div class="col-md-6 text-right">
  {{ $cursos->links() }}
  </div>
  </div>
  <table class="table table-hover">
      <thead>
                  <tr>
                    <th>&nbsp;</th>
                    <th>Nombre <a href="{{route("cursos.index", ["name", (($order_field=="name")?($order_direction=="asc"?"desc":"asc"):"asc")])}}" class="pull-right"><i class="menu-icon fa fa-sort"></i></a></th>
                    <th>Fecha <a href="{{route("cursos.index", ["created_at", (($order_field=="created_at")?($order_direction=="asc"?"desc":"asc"):"asc")])}}" class="pull-right"><i class="menu-icon fa fa-sort"></i></a></th>
                 
                  </tr>
      </thead>
      <tbody>
          @foreach($cursos as $curso)
                  
                  <tr>
                    <td><a href="{{ route('cursos.edit', $curso['id']) }}"><i class="menu-icon fa fa-edit"></i></a> <a class="btn-elimina" href="#" ref="{{ $curso['id'] }}"><i class="menu-icon fa fa-trash"></i></a><form action="{{ route('cursos.destroy', $curso['id']) }}" id="delete{{ $curso['id'] }}" method="post">@csrf<input type="hidden" name="_method" value="delete" /></form></td>
                    <td>{{$curso['nombre']}}</td>
                    <td>{{$curso['created_at']}}</td>
                  </tr>

           @endforeach
      </tbody>

  </table>
  <div class="row">
    <div class="col-md-3">
     <select class="form-control universidad_id" >
         @foreach ($universidades as $u)
            <option value="{{ $u->id }}" {{ $u->id==$universidad_id?'selected="selected"':'' }}>{{ $u->nombre }}</option>
         @endforeach      
     </select>
  </div>
  <div class="col-md-3">
    <a href="{{route("cursos.create")}}" class="btn btn-default">Agregar</a>
  </div>
  <div class="col-md-6 text-right">
  {{ $cursos->links() }}
  </div>
  </div>
</div>
<script type="text/javascript">
  
  $(document).ready(function(){

    $(".btn-elimina").click(function(e){

        e.preventDefault();

        $("#delete" + $(this).attr("ref") ).submit();


    });

    $(".universidad_id").change(function(){

        window.location = '{{route("cursos.index")}}/' + $(this).val();


    });



  });

</script>
@endsection