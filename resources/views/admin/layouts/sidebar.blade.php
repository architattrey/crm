
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= url('/')?>/public/dist/img/user1-128x128.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
        
          <p>{{auth('lg')->user()?auth('lg')->user()->name:(auth('admin')->user()?auth('admin')->user()->name:auth('bdm')->user()->name)}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          @if(auth('lg')->user())
            <a href="{{route('lg_dashboard')}}">
          @elseif(auth('admin')->user())
            <a href="{{route('admin_dashboard')}}">
          @elseif(auth('bdm')->user())
            <a href="{{route('bdm_dashboard')}}">
          @endif
            <i class="fa fa-dashboard"></i><span>Dashboard</span>
           </a>
        </li>
        <!-- agents tab -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Clients</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview">
            @php 
              $id = auth('lg')->user() ? auth('lg')->user()->id : (auth('admin')->user() ? auth('admin')->user()->id:( auth('bdm')->user() ? auth('bdm')->user()->id : "")); 
              $user_type = auth('lg')->user() ? auth('lg')->user()->is_lg : (auth('admin')->user() ?auth('admin')->user()->is_super:(auth('bdm')->user() ? auth('bdm')->user()->is_bdm : ""));
            @endphp
            
            @if(auth('lg')->user())
            <li><a href="{{route('clients-registraion-lg')}}"><i class="fa fa-circle-o"></i> &nbsp;Client Registration</a></li>
            <li><a href="{{url('show-leads-lg/'.encrypt($id).'/'.$user_type)}}"><i class="fa fa-circle-o"></i>&nbsp; Your leads</a></li>


            @elseif(auth('admin')->user())
            <li><a href="{{route('clients-registraion-admin')}}"><i class="fa fa-circle-o"></i> &nbsp;Client Registration</a></li>
            <li><a href="{{url('show-leads-admin/'.encrypt($id).'/'.$user_type)}}"><i class="fa fa-circle-o"></i>&nbsp; Your leads</a></li>
            <li><a href="{{route('get-live-clients')}}"><i class="fa fa-circle-o"></i>  &nbsp;All Ongoing Clients</a></li>
            <li><a href="{{route('get-deleted-clients')}}"><i class="fa fa-circle-o"></i>  &nbsp;All deleted Clients</a></li>


            @elseif(auth('bdm')->user())
            <li><a href="{{route('clients-registraion-bdm')}}"><i class="fa fa-circle-o"></i> &nbsp;Client Registration</a></li>
            <li><a href="{{url('show-leads-bdm/'.encrypt($id).'/'.$user_type)}}"><i class="fa fa-circle-o"></i>&nbsp; Your leads</a></li>
            <li><a href="{{url('assigned-leads')}}"><i class="fa fa-circle-o"></i>&nbsp; Assigned leads</a></li>

             
            @endif
          </ul>
        </li>
        <!-- -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>