
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset("/bower_components/admin-lte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->
              @foreach(config('admin.menu') as $item)
                                     
                @if( isset($item['submenu']))
                <li class="treeview">
                  <a href="#"><i class="fa fa-{{$item['icon']}}"></i> <span>{{$item['name']}}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                    <ul class="treeview-menu">
                      @foreach($item["submenu"] as $item2)
                        <li><a href="{{ route($item2['route']) }}">{{$item2['name']}}</a></li>
                      @endforeach
                    </ul>
               </li>    

               @else

                <li><a href="{{ route($item['route']) }}"><i class="fa fa-{{ (isset($item['icon']))?$item['icon']:'link' }}"></i> <span>{{ $item['name'] }}</span></a></li>           
                @endif

              @endforeach

      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>