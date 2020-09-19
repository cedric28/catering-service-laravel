<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->
    
    
    <!-- Sidebar content -->
    <div class="sidebar-content">
    
        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="#"><img src="{{ asset('global_assets/images/placeholders/image.png') }}" width="38" height="38" class="rounded-circle" alt=""></a>
                    </div>
    
                    <div class="media-body">
                        <div class="media-title font-weight-semibold">{{ (Auth::user()->first_name) }}</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-google-plus2 font-size-sm"></i> &nbsp;{{ Auth::user()->email }}
                        </div>
                    </div>
    
                    <div class="ml-3 align-self-center">
                        <a href="{{ route('user-profile')}}" class="text-white">
                            <i class="icon-cog3"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->
    
    
        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
    
                <!-- Main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
                  
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ (request()->is('home')) ? 'nav-link active' : '' }}"><i class="icon-home4"></i><span>Dashboard</span></a>
                    </li>
                    @can('isAdmin')
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-cube3"></i><span>User Management</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Starter kit">
                                <li class="nav-item">
                                    <a href="{{ route('users.index')}}" class="nav-link {{ (request()->is('users*')) ? 'nav-link active' : '' }}">
                                        <i class="icon-user"></i>
                                        <span>System User</span>
                                    </a>
                                </li>
                        
                                <li class="nav-item">
                                    <a href="{{ route('roles.index')}}" class="nav-link {{ (request()->is('roles*')) ? 'nav-link active' : '' }}">
                                        <i class="icon-cube4"></i>
                                        <span>User Role</span>
                                    </a>
                                </li>
                            
                            </ul>
                        </li>
                    @endcan
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-cube3"></i><span>Expense Management</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Starter kit">
                            <li class="nav-item">
                                <a href="{{ route('expense.index')}}" class="nav-link {{ (request()->is('expense*')) ? 'nav-link active' : '' }}"><i class="icon-cube4"></i><span>Expenses</span></a>
                            </li>
                            @can('isAdmin')
                                <li class="nav-item">
                                    <a href="{{ route('category.index')}}" class="nav-link {{ (request()->is('category*')) ? 'nav-link active' : '' }}"><i class="icon-folder-plus"></i><span>Expense Categories</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    
                   
                <!-- /layout -->
            </ul>
        </div>
        <!-- /main navigation -->
    </div>
    <!-- /sidebar content -->
    </div>
    <!-- /main sidebar -->
    
    