<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                            placeholder="Search for..." aria-label="Search"
                            aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        @if(Auth::user()->job_type_id != 1)
        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                @if(Auth::user()->job_type_id == 2)
                    @if($notificationStaffCount > 0)
                        <span class="badge badge-danger badge-counter">{{ $notificationStaffCount }}</span>
                    @endif
                @else 
                    @if($notificationStaffingCount > 0)
                        <span class="badge badge-danger badge-counter">{{ $notificationStaffingCount }}</span>
                    @endif
                @endif
              
               
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Task Notification 
                </h6>
                @if(Auth::user()->job_type_id == 2)
                    @forelse($notificationStaff as $notif)
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('my-tasks.show', $notif->id) }}">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{ Str::date_task_format($notif->created_at) }}</div>
                            <span class="font-weight-bold">You have an upcoming Event {{ ucwords($notif->planner_task_staff->planner_task->planner->event_name) }}</span>
                        </div>
                    </a>
                    @empty
                    <a class="dropdown-item text-center small text-gray-500" href="#">No Task Show</a>
                    @endforelse
                @else 
                    @forelse($notificationStaffing as $notif)
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('my-tasks.show', $notif->id) }}">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{ Str::date_task_format($notif->created_at) }}</div>
                            <span class="font-weight-bold">You have an upcoming Event {{ ucwords($notif->planner_staffing->planner->event_name) }}</span>
                        </div>
                    </a>
                    @empty
                    <a class="dropdown-item text-center small text-gray-500" href="#">No Task Show</a>
                    @endforelse
                @endif
            </div>
        </li>
        @endif

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><strong>{{ ucwords(Auth::user()->name) }}</strong> ({{ strtoupper(Auth::user()->role->name) }}) <br/> Welcome!</span>
               
                @can('isAdmin')
                <img class="img-profile rounded-circle"
                    src="{{ asset('images/undraw_profile.svg') }}">
                @endcan
                @can('isHeadStaff')
                <img class="img-profile rounded-circle"
                    src="{{ asset('images/undraw_profile_1.svg') }}">
                @endcan
                @can('isStaff')
                <img class="img-profile rounded-circle"
                    src="{{ asset('images/undraw_profile_2.svg') }}">
                @endcan
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('user-profile')}}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <!-- <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a> -->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" data-close="true" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>