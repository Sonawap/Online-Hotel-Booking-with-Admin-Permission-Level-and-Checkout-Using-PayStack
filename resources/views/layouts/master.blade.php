
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title') - The RockValley Hotel</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" >
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4 sidebar-light-primary">
        <a href="index3.html" class="brand-link navbar-primary">
            <span class="brand-text font-weight-light">RockVallery</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="#" class="d-block">Administator</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="fas fa-users-cog nav-icon"></i>
                        <i class="right fas fa-angle-left"></i>
                        <p>User Management</p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('user.index') }}" class="nav-link">
                                <i class="fas fa-users-cog nav-icon"></i>
                                <p>User</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('role.index') }}" class="nav-link">
                                <i class="fas fa-users-cog nav-icon"></i>
                                <p>Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('permission.index')}}" class="nav-link">
                                <i class="fas fa-users-cog nav-icon"></i>
                                <p>Permission</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('category.index') }}" class="nav-link">
                        <i class="fas fa-bullseye nav-icon"></i>
                        <p>Categories</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('room.index') }}" class="nav-link">
                        <i class="fas fa-atom nav-icon"></i>
                        <p>Rooms</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('notifications') }}" class="nav-link">
                        <i class="fas fa-bell nav-icon"></i>
                        <p>Notifications</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('booking.index') }}" class="nav-link">
                        <i class="fas fa-users-cog nav-icon"></i>
                        <p>Bookings</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('password.change') }}" class="nav-link">
                        <i class="fas fa-lock nav-icon"></i>
                        <p>Change Password</p>
                        </a>
                    </li>


                    <li class="nav-item has-treeview">
                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>
                            Logout
                        </p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>

                </ul>
            </nav>

        </div>

    </aside>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@yield('bc')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">@yield('bc')</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="content">
            <div class="container-fluid">
                @include('partials/alert')
                <vue-progress-bar></vue-progress-bar>
                @yield('content')
            </div>
        </div>
        <!-- /.content -->
    </div>

    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            <span>Developer:<a href="http://sonawap.com.ng" target="_blank"> Sonawap</a></span>
        </div>
        <strong>The Rock Vallary Hotel. {{  date('Y') }}</a>.</strong> All rights reserved.
    </footer>
</div>

<script src="{{ asset('js/app.js') }}"></script>
@yield('script')
</body>
</html>
