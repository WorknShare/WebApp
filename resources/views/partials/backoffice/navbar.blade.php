 <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="{{ route('admin.home') }}" class="logo">
      <img src="{{ asset('img/logo32.png') }}">
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">Work'n Share</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">{{ Auth::user()->surname . ' ' . Auth::user()->name }}</span>
            </a>
            @component('components.user_dropdown')
                @slot('username')
                    {{ Auth::user()->surname . ' ' . Auth::user()->name }}
                @endslot
                @slot('smalltext')
                    {{ backoffice_role(Auth::user()->role) }}
                @endslot
            @endcomponent
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVIGATION</li>
        {!! Html::adminNavMenu('admin.home', 'admin', 'Tableau de bord', 'fa-home') !!}
        {!! Html::adminNavMenu('site.index', 'site', 'Sites', 'fa-map-marker') !!}
        <li class="treeview {!! strpos(Route::currentRouteName(), 'user.') !== FALSE || strpos(Route::currentRouteName(), 'employee.') !== FALSE ? 'menu-open active' : '' !!}">
          <a href="#">
            <i class="fa fa-user"></i> <span>Utilisateurs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li {!! strpos(Route::currentRouteName(), 'employee.') !== FALSE ? 'class="active"' : '' !!}><a href="{{ route('employee.index') }}"><i class="fa fa-circle-o"></i> Employés</a></li>
            <li {!! strpos(Route::currentRouteName(), 'user.') !== FALSE ? 'class="active"' : '' !!}><a href="{{ route('user.index') }}"><i class="fa fa-circle-o"></i> Clients</a></li>
          </ul>
        </li>
        <li class="treeview {!! strpos(Route::currentRouteName(), 'plan.') !== FALSE || strpos(Route::currentRouteName(), 'planadvantage.') !== FALSE ? 'menu-open active' : '' !!}">
          <a href="#">
            <i class="fa fa-credit-card"></i> <span>Forfaits</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li {!! strpos(Route::currentRouteName(), 'plan.') !== FALSE ? 'class="active"' : '' !!}><a href="{{ route('plan.index') }}"><i class="fa fa-circle-o"></i> Forfaits</a></li>
            <li {!! strpos(Route::currentRouteName(), 'planadvantage.') !== FALSE ? 'class="active"' : '' !!}><a href="{{ route('planadvantage.index') }}"><i class="fa fa-circle-o"></i> Avantages</a></li>
          </ul>
        </li>
        {!! Html::adminNavMenu('typeOfRooms.index', 'typeOfRooms', 'Types de salle', 'fa-puzzle-piece') !!}
        {!! Html::adminNavMenu('equipmenttype.index', 'equipmenttype', 'Matériel', 'fa-laptop') !!}
        {!! Html::adminNavMenu('meal.index', 'meal', 'Repas', 'fa-apple') !!}
        {!! Html::adminNavMenu('order.index_admin', 'order', 'Réservations', 'fa-shopping-bag') !!}


      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
