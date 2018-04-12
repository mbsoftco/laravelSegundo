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
    <a href="{{route("universidades.create")}}" class="btn btn-default">Agregar</a>
  </div>
  <div class="col-md-9 text-right">
  {{ $universidades->links() }}
  </div>
  </div>
  <table class="table table-hover">
      <thead>
                  <tr>
                    <th>&nbsp;</th>
                    <th>Nombre <a href="{{route("universidades.index", ["nombre", (($order_field=="nombre")?($order_direction=="asc"?"desc":"asc"):"asc")])}}" class="pull-right"><i class="menu-icon fa fa-sort"></i></a></th>
                    <th>Fecha <a href="{{route("universidades.index", ["created_at", (($order_field=="created_at")?($order_direction=="asc"?"desc":"asc"):"asc")])}}" class="pull-right"><i class="menu-icon fa fa-sort"></i></a></th>
                 
                  </tr>
      </thead>
      <tbody>
          @foreach($universidades as $uni)
                  
                  <tr>
                    <td><a href="{{ route('universidades.edit', $uni['id']) }}"><i class="menu-icon fa fa-edit"></i></a> <a class="btn-elimina" href="#" ref="{{ $uni['id'] }}"><i class="menu-icon fa fa-trash"></i></a><form action="{{ route('universidades.destroy', $uni['id']) }}" id="delete{{ $uni['id'] }}" method="post">@csrf<input type="hidden" name="_method" value="delete" /></form></td>
                    <td>{{$uni['nombre']}}</td>
                    <td>{{$uni['created_at']}}</td>
                  </tr>

           @endforeach
      </tbody>

  </table>
  <div class="row">
  <div class="col-md-3">
    <a href="{{route("universidades.create")}}" class="btn btn-default">Agregar</a>
  </div>
  <div class="col-md-9 text-right">
  {{ $universidades->links() }}
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