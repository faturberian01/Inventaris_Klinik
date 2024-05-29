<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion d-md-none" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-hospital"></i>
        </div>
        <div class="sidebar-brand-text mx-3">MA Medika</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('histories.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Histories</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('stocks.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Input Stocks</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Management Data
    </div>

    @if (auth()->user()->isAdmin())
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDataMaster"
                aria-expanded="true" aria-controls="collapseDataMaster">
                <i class="fas fa-fw fa-database"></i>
                <span>Data Master</span>
            </a>
            <div id="collapseDataMaster" class="collapse" aria-labelledby="headingDataMaster"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('products.index') }}">Products</a>
                </div>
            </div>
        </li>
    @endif

    <li class="nav-item">
        <a class="nav-link" href="{{ route('reports.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Report</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDataUtama"
            aria-expanded="true" aria-controls="collapseDataUtama">
            <i class="fas fa-fw fa-folder-open"></i>
            <span>Data Utama</span>
        </a>
        <div id="collapseDataUtama" class="collapse" aria-labelledby="headingDataUtama" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('nota-intern-list')
                    <a class="collapse-item" href="{{ route('nota-interns.index') }}">Nota Intern</a>
                @endcan
                @can('surat-masuk-list')
                    <a class="collapse-item" href="{{ route('surat-masuks.index') }}">Surat Masuk</a>
                @endcan
                @can('surat-keluar-list')
                    <a class="collapse-item" href="{{ route('surat-keluars.index') }}">Surat Keluar</a>
                @endcan
            </div>
        </div>
    </li> --}}

    <!-- Heading -->
    {{-- <div class="sidebar-heading">
        Laporan
    </div> --}}

    <!-- Nav Item - Pages Collapse Menu -->
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports"
            aria-expanded="true" aria-controls="collapseReports">
            <i class="fas fa-fw fa-database"></i>
            <span>Laporan</span>
        </a>
        <div id="collapseReports" class="collapse" aria-labelledby="headingReports" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('surat-masuk-report')
                    <a class="collapse-item" href="{{ route('surat-masuks.report') }}">Surat Masuk</a>
                @endcan
                @can('surat-keluar-report')
                    <a class="collapse-item" href="{{ route('surat-keluars.report') }}">Surat Keluar</a>
                @endcan
                @can('nota-intern-report')
                    <a class="collapse-item" href="{{ route('nota-interns.report') }}">Nota Intern</a>
                @endcan
            </div>
        </div>
    </li> --}}

    <!-- Heading -->
    {{-- <div class="sidebar-heading">
        Users Management
    </div> --}}

    <!-- Nav Item - Pages Collapse Menu -->
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-users"></i>
            <span>Users Management</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('role-list')
                <a class="collapse-item" href="{{ route('roles.index') }}">Roles</a>
                @endcan
                @can('user-list')
                <a class="collapse-item" href="{{ route('users.index') }}">Users</a>
                @endcan
            </div>
        </div>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
