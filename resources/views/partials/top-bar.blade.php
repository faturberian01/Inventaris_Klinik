<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <div>
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.index') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-hospital"></i>
            </div>
            <div class="sidebar-brand-text mx-3">MA Medika</div>
        </a>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item d-none d-md-block">
            <a class="nav-link fw-bold {{ request()->routeIs('dashboard.index') ? 'text-primary' : 'text-dark' }}"
                href="{{ route('dashboard.index') }}">
                {{-- <i class="fas fa-fw fa-tachometer-alt"></i> --}}
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <span class="mb-1">Dashboard</span>
                    @if (request()->routeIs('dashboard.index'))
                        <span style="width: 50px; border-radius: 5px; border: 1px solid #EEE;"></span>
                    @endif
                </div>
            </a>
        </li>
        @if (auth()->user()->isAdmin())
            <li class="nav-item d-none d-md-block">
                <a class="nav-link fw-bold {{ request()->routeIs('products.*') ? 'text-primary' : 'text-dark' }}"
                    href="{{ route('products.index') }}">
                    {{-- <i class="fas fa-fw fa-tachometer-alt"></i> --}}
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <span class="mb-1">Products</span>
                        @if (request()->routeIs('products.*'))
                            <span style="width: 50px; border-radius: 5px; border: 1px solid #EEE;"></span>
                        @endif
                    </div>
                </a>
            </li>
        @endif
        <li class="nav-item d-none d-md-block">
            <a class="nav-link fw-bold {{ request()->routeIs('stocks.*') ? 'text-primary' : 'text-dark' }}"
                href="{{ route('stocks.index') }}">
                {{-- <i class="fas fa-fw fa-tachometer-alt"></i> --}}
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <span class="mb-1">Input Stocks</span>
                    @if (request()->routeIs('stocks.*'))
                        <span style="width: 50px; border-radius: 5px; border: 1px solid #EEE;"></span>
                    @endif
                </div>
            </a>
        </li>
        <li class="nav-item d-none d-md-block">
            <a class="nav-link fw-bold {{ request()->routeIs('reports.*') ? 'text-primary' : 'text-dark' }}"
                href="{{ route('reports.index') }}">
                {{-- <i class="fas fa-fw fa-tachometer-alt"></i> --}}
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <span class="mb-1">Report</span>
                    @if (request()->routeIs('reports.*'))
                        <span style="width: 50px; border-radius: 5px; border: 1px solid #EEE;"></span>
                    @endif
                </div>
            </a>
        </li>
        <li class="nav-item d-none d-md-block">
            <a class="nav-link fw-bold {{ request()->routeIs('histories.*') ? 'text-primary' : 'text-dark' }}"
                href="{{ route('histories.index') }}">
                {{-- <i class="fas fa-fw fa-tachometer-alt"></i> --}}
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <span class="mb-1">Histories</span>
                    @if (request()->routeIs('histories.*'))
                        <span style="width: 50px; border-radius: 5px; border: 1px solid #EEE;"></span>
                    @endif
                </div>
            </a>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span
                    class="badge badge-danger badge-counter">{{ count($notifications) > 0 ? count($notifications) : '' }}</span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                style="max-height: 400px; overflow-y: auto;" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Notifications
                </h6>
                @foreach ($notifications as $notification)
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3 d-flex align-items-center justify-content-center">
                            <i class="fas fa-exclamation-triangle fa-fw"></i>
                        </div>
                        <div>
                            <div>{{ $notification }}</div>
                            {{-- <div class="text-truncate">{{ $notification }}</div> --}}
                            {{-- <div class="small text-gray-500">{{ $notification }}</div> --}}
                        </div>
                    </a>
                @endforeach
            </div>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                <img class="img-profile border rounded-circle" src="{{ asset('/images/default.jpg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                {{-- <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div> --}}
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('auth.logout') }}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Logout</button>
                </div>
            </form>
        </div>
    </div>
</div>
