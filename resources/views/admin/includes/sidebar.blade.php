<div class="main-sidebar sidebar-style-2" tabindex="1">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}"><span class="logo-name"><img src="{{asset('client_assets/img/logo/logo.jpg')}}" /></span> </a>
            <a href="{{ route('admin.dashboard') }}"><span class="logo-fm"><img src="{{asset('client_assets/img/logo/logo.jpg')}}" /></span> </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header"></li>
            <li class="dropdown {{ Request::is('admin/dashboard*') ? 'active' : ' ' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="ph-gauge"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0);" class="menu-toggle nav-link has-dropdown {{ Request::is('admin/profile*') || Request::is('admin/password*') || Request::is('admin/detail*') ? 'active' : ' ' }}" >
                    <i class="ph-identification-card"></i>
                    <span>Manage Account</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/profile*') ? 'active' : ' ' }}"><a class="nav-link" href="{{ route('admin.profile') }}">My Profile</a></li>
                    <li class="{{ Request::is('admin/password*') ? 'active' : ' ' }}"><a class="nav-link" href="{{ route('admin.password') }}">Change Password</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0);" class="menu-toggle nav-link has-dropdown {{ Request::is('admin/students*') ? 'active' : ' ' }}">
                    <i class="ph ph-user-list"></i>
                    <span> Student Management</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/students/create') ? 'active' : ' ' }}"><a class="nav-link" href="{{ route('students.create') }}">Create  User</a></li>
                    <li class="{{ Request::is('admin/students') ? 'active' : ' ' }}"><a class="nav-link" href="{{ route('students.index') }}"> User List</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0);" class="menu-toggle nav-link has-dropdown {{ Request::is('admin/faculty*') ? 'active' : ' ' }}">
                    <i class="ph ph-user-list"></i>
                    <span> Faculty Management</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/faculty/create') ? 'active' : ' ' }}"><a class="nav-link" href="{{ route('faculty.create') }}">Create  User</a></li>
                    <li class="{{ Request::is('admin/faculty') ? 'active' : ' ' }}"><a class="nav-link" href="{{ route('faculty.index') }}"> User List</a></li>
                </ul>
            </li>
            <li class="dropdown {{ Request::is('admin/country*') ? 'active' : ' ' }}">
                <a href="{{ route('country.index') }}">
                    <i class="ph ph-map-pin"></i>
                    <span>Country</span>
                </a>
            </li>

            <li class="dropdown {{ Request::is('admin/state*') ? 'active' : ' ' }}">
                <a href="{{ route('state.index') }}">
                    <i class="ph ph-compass"></i>
                    <span>State</span>
                </a>
            </li>
            {{-- <li class="dropdown">
                <a href="" class="menu-toggle nav-link has-dropdown">
                    <i class="ph-file"></i>
                    <span>B2B Markup Management</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="admin-markup.html">Admin Markup</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="" class="menu-toggle nav-link has-dropdown">
                    <i class="ph-wallet"></i>
                    <span>B2B Deposits</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="">Manage / Add Deposits</a></li>
                    <li><a class="nav-link" href="">Manage New Deposits
                            Request</a></li>
                    <li><a class="nav-link" href="">Approved Deposits Request</a>
                    </li>
                    <li><a class="nav-link" href="">Deposit History</a></li>
                    <li><a class="nav-link" href="">Refund Deposit</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="">
                    <i class="ph-ticket"></i>
                    <span>All Cancel Ticket</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="">
                    <i class="ph-user-circle"></i>
                    <span>Regional Manager</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="">
                    <i class="ph-fingerprint"></i>
                    <span>Itinerary</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="">
                    <i class="ph-fingerprint"></i>
                    <span>Upload Ticket</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="">
                    <i class="ph-fingerprint"></i>
                    <span>Student Database</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="">
                    <i class="ph-fingerprint"></i>
                    <span>My Operator Log Details</span>
                </a>
            </li> --}}
        </ul>
    </aside>
</div>
