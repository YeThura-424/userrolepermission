<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>User Role Permission</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="{{asset('appstructure/css/styles.css')}}" rel="stylesheet" />
    <link href="{{asset('appstructure/css/edit.css')}}" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{asset('appstructure/assets/icofont/icofont.min.css')}}">
    <link rel="stylesheet" href="{{asset('appstructure/assets/bootstrap/css/bootstrap.min.css')}}" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script src="{{asset('fileupload/jquery.uploadPreview.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('appstructure/assets/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
</head>


<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">RATHAN ERP</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Navbar Search-->
        <div class="d-none d-md-inline-block ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <i class="fas fa-search"></i>
                <input class="form-control" id="search" name="search" type="text" placeholder="Search for..." />
            </div>
            <div class="list-group">

            </div>
        </div>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="userprofile">
                        <div class="userinfo">
                            <span>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
                            <span>{{implode(Auth::user()->getRoleNames()->toArray())}}</span>
                        </div>
                        <div class="profile">
                            <img class="profileimg" src="{{asset(Auth::user()->profile)}}" alt="User Image">
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action=" {{route('logout')}} " method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        @can('Dashboard','Order')
                        <div class="sb-sidenav-menu-heading">General</div>
                        @endcan
                        @can('Dashboard')
                        <a class="nav-link {{Request::segment(1) === 'dashboard' ? 'active':''}}" href="index.html">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            Dashboard
                        </a>
                        @endcan
                        @can('Order')
                        <a class="nav-link {{Request::segment(1) === 'orders' ? 'active':''}}" href="index.html">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            Orders
                        </a>
                        @endcan
                        @can('User','Permission','Role-Permission','User-Role-Permission')
                        <div class="sb-sidenav-menu-heading">Authentication</div>
                        @endcan
                        @can('User')
                        <a class="nav-link {{Request::segment(1) === 'user' ? 'active':''}}" href="{{route('user.index')}}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            Users Master
                        </a>
                        @endcan
                        @can('Permission','Role-Permission','User-Role-Permission')
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-columns"></i>
                            </div>
                            Roles & Permission
                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>
                        @endcan
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link collapse-nav-link {{Request::segment(1) === 'permission' ? 'active':''}}" href="{{route('permission.index')}}">Permission Master</a>
                                <a class="nav-link collapse-nav-link {{Request::segment(1) === 'rolepermission' ? 'active':''}}" href="{{route('rolepermission.index')}}">Role Permission</a>
                                <a class="nav-link collapse-nav-link {{Request::segment(1) === 'userrolepermission' ? 'active':''}}" href="{{route('userrolepermission.index')}}">User Role Permission</a>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">Master</div>
                        @can('Subcategory')
                        <a class="nav-link {{Request::segment(1) === 'subcategory' ? 'active':''}}" href="{{route('subcategory.index')}}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            Subcategory
                        </a>
                        @endcan
                        @can('Category')
                        <a class="nav-link {{Request::segment(1) === 'category' ? 'active':''}}" href="{{route('category.index')}}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            Category
                        </a>
                        @endcan
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">

            {{$slot}}
            </main>
            <footer class="py-4 mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2021</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{asset('appstructure/js/scripts.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{asset('appstructure/js/datatables-simple-demo.js')}}"></script>
    @yield("script_content");

    <script type="text/javascript">
        $('#search').on('keyup', function() {
            var value = $(this).val();
            // alert(value);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            $.get('/search', {
                    data: value,
                },
                function(data) {
                    $('.list-group').html(data);
                })
        })
    </script>

</body>

</html>