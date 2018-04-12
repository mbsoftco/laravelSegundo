<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$pageName}}
      </h1>


    <ol class="breadcrumb">
        <li><a href="{{ route("admin") }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
       @for($i = 2; $i < count(Request::segments()); $i++)
          <li>
             <a href="{{ URL::to( implode( '/', array_slice(Request::segments(), 0 ,$i, true)))}}">
                {{ucwords(Request::segment($i))}}
             </a>
          </li>
       @endfor
        <li class="active">{{$pageName}}</li>
      </ol>
      
    </section>