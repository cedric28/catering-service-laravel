<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">CREATIVE MOMENTS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ (request()->is('home')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>


    <li class="nav-item {{ (request()->is('planners*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('planners.index') }}">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Planner</span>
        </a>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#planner"
            aria-expanded="true" aria-controls="planner">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Planner</span>
        </a>
        <div id="planner" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="cards.html">Events</a>
                <a class="collapse-item" href="buttons.html">Event Types</a>
            </div>
        </div>
    </li> -->

    <li class="nav-item {{ (request()->is('inventories*')) || (request()->is('inventory-category*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#inventory"
            aria-expanded="true" aria-controls="inventory">
            <i class="fas fa-fw fa-database"></i>
            <span>Inventory</span>
        </a>
        <div id="inventory" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ (request()->is('inventories*')) ? 'active' : '' }}" href="{{ route('inventories.index')}}">Inventory Entry</a>
                <a class="collapse-item {{ (request()->is('inventory-category*')) ? 'active' : '' }}" href="{{ route('inventory-category.index')}}">Inventory Category</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ (request()->is('foods*')) || (request()->is('food-category*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#foods"
            aria-expanded="true" aria-controls="foods">
            <i class="fas fa-fw fa-utensils"></i>
            <span>Foods</span>
        </a>
        <div id="foods" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ (request()->is('foods*')) ? 'active' : '' }}" href="{{ route('foods.index')}}">Food Entry</a>
                <a class="collapse-item {{ (request()->is('food-category*')) ? 'active' : '' }}" href="{{ route('food-category.index')}}">Food Category</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ (request()->is('packages*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('packages.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>Package</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        REPORTS
    </div>
    <li class="nav-item {{ (request()->is('users*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.index')}}">
            <i class="fas fa-fw fa-users"></i>
            <span>User's Activities</span></a>
    </li>
    <li class="nav-item {{ (request()->is('users*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.index')}}">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Monthly Revenue</span></a>
    </li>
     <!-- Divider -->
     <hr class="sidebar-divider">
    @can('isAdmin')
    <!-- Heading -->
    <div class="sidebar-heading">
        SETTINGS
    </div>
  
    <!-- Nav Item - Charts -->
    <li class="nav-item {{ (request()->is('users*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.index')}}">
            <i class="fas fa-fw fa-users"></i>
            <span>System Users</span></a>
    </li>

    <!-- Nav Item - Tables -->
    {{-- <li class="nav-item">
        <a class="nav-link {{ (request()->is('roles*')) ? 'nav-link active' : '' }}" href="{{ route('roles.index')}}">
            <i class="fas fa-fw fa-cube"></i>
            <span>User Role</span></a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @endcan
    <!-- Sidebar Toggler (Sidebar) -->
    {{-- <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> --}}

</ul>