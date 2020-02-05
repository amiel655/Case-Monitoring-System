<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link text-center my-auto">
        <img src="./img/logo/PAO_Logo.jpg" alt="PAO Logo" class="brand-image img-circle elevation-3">
        <small class="brand-text font-weight-light">Public Attorney's Office</small>
        <small class="brand-text district">San Fernando City District III</small>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image my-auto">
                <img src="./img/profile-picture/{{ Auth::user()->image }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="/profile" class="d-block">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}<br>
                    @if(Auth::user()->type === 'Staff')
                        <small>Staff</small>
                    @endif
                    @if(Auth::user()->type === 'Admin')
                        <small>Lawyer</small>
                    @endif
                    @if(Auth::user()->type === 'Super Admin')
                        <small>District Public Attorney</small>
                    @endif
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @can('isAdminAndSuperAdmin')
                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link">
                        <dashboard-icon></dashboard-icon>
                        <p class="ml-3">Dashboard</p>
                    </router-link>
                </li>
                @endcan
                @can('isAdminAndSuperAdmin')
                <li class="nav-item">
                            <router-link to="/cases" class="nav-link">
                                <court-icon></court-icon>
                                <p class="ml-3">Cases</p>
                            </router-link>
                        </li>
                @endcan
                @can('isStaffAndSuperAdmin')
                <li class="nav-item" v-on:click="clearClientInfo">
                            <router-link to="/interview-form" class="nav-link">
                                <interview-form-icon></interview-form-icon>
                                <p class="ml-3">Interview Form</p>
                            </router-link>
                        </li>
                @endcan
                <li class="nav-item" v-on:click="clearClientRequest">
                            <router-link to="/clients" class="nav-link" >
                                <clients-icon></clients-icon>
                                <p class="ml-3">Clients</p>
                            </router-link>
                        </li>
                <li class="nav-item">
                            <router-link to="/calendar" class="nav-link">
                                <calendar-icon></calendar-icon>
                                <p class="ml-3">Calendar</p>
                            </router-link>
                        </li>
                {{-- @can('isSuperAdmin')
                <li class="nav-item">
                    <router-link to="/developer" class="nav-link">
                        <i class="nav-icon material-icons">
                            developer_board
                        </i>
                        <p class="ml-3">Developer</p>
                    </router-link>
                </li>
                @endcan --}}
                <li class="nav-item">
                    <router-link to="/profile" class="nav-link">
                        <profile-icon></profile-icon>
                        <p class="ml-3">Profile</p>
                    </router-link>
                </li>
                @can('isSuperAdmin')
                <li class="nav-item has-treeview">
                    <a class="nav-link">
                        <management-icon></management-icon>
                        <p class="ml-3">
                            Management
                        </p>
                        <i class="right material-icons">
                            chevron_left
                        </i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/users" class="nav-link">
                                <users-icon></users-icon>
                                <p class="ml-3">Users</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/audit" class="nav-link">
                                <audit-icon></audit-icon>
                                <p class="ml-3">Audit</p>
                            </router-link>
                        </li>
                    </ul>
                </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="text-danger nav-icon material-icons">
                            power_settings_new
                        </i>
                        <p class="ml-3">{{ __('Logout') }}</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @can('isSuperAdmin')
                <li class="nav-item">
                    <a href="./pdf/User Manual - District Public Attorney.pdf" target="_blank" class="nav-link">
                        <i class="material-icons">help_outline</i>
                        <p class="ml-3">Help</p>
                    </a>
                </li>
                @endcan
                @can('isAdmin')
                <li class="nav-item">
                    <a href="./pdf/User Manual - Lawyer.pdf" target="_blank" class="nav-link">
                        <i class="material-icons">help_outline</i>
                        <p class="ml-3">Help</p>
                    </a>
                </li>
                @endcan
                @can('isStaff')
                <li class="nav-item">
                    <a href="./pdf/User Manual - Staff.pdf" target="_blank" class="nav-link">
                        <i class="material-icons">help_outline</i>
                        <p class="ml-3">Help</p>
                    </a>
                </li>
                @endcan
            </ul>
        </nav>
    </div>
</aside>
