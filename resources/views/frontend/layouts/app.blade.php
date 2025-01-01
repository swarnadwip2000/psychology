<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="https://templates.iqonic.design/cloudbox/html/assets/images/favicon.ico" />
    <link rel="stylesheet" href="{{ asset('assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/backende209.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/developer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/fonts/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/dx/css/dx.light.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/devextreme-quill@1.7.1/dist/dx-quill.core.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
</head>

<body class="  ">
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>

    <div class="wrapper">

        <div class="iq-sidebar  sidebar-default ">
            <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
                <a href="index.html" class="header-logo">
                    <img src="{{ asset('assets/images/logo.jpg') }}" class="img-fluid rounded-normal light-logo" alt="logo">
                    <!-- <img src="../assets/images/logo-white.png" class="img-fluid rounded-normal darkmode-logo" alt="logo"> -->
                </a>
                <div class="iq-menu-bt-sidebar">
                    <i class="las la-bars wrapper-menu"></i>
                </div>
            </div>
            <div class="data-scrollbar" data-scroll="1">

                <nav class="iq-sidebar-menu">
                    <ul id="iq-sidebar-toggle" class="iq-menu">
                        <li class="active">
                            <a href="{{ route('dashboard') }}" class="">
                                <i class="las la-home iq-arrow-left"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{ route('auth_student_list') }}" class="">
                                <i class="lar la-user iq-arrow-left"></i><span>Students</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{ route('auth_faculity_list') }}" class="">
                                <i class="lar la-user iq-arrow-left"></i><span>faculities</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="p-3"></div>
            </div>
        </div>
        <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
                <nav class="navbar navbar-expand-lg navbar-light p-0">
                    <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                        <i class="ri-menu-line wrapper-menu"></i>
                        <a href="index.html" class="header-logo">
                            <img src="{{ asset('images/logo.jpg') }}" class="img-fluid rounded-normal light-logo"
                                alt="logo">
                            <img src="../assets/images/logo-white.png" class="img-fluid rounded-normal darkmode-logo"
                                alt="logo">
                        </a>
                    </div>
                    <div class="iq-search-bar device-search">

                        <form>
                            <div class="input-prepend input-append">
                                <div class="btn-group">
                                    <label class="dropdown-toggle searchbox" data-toggle="dropdown">
                                        <input class="dropdown-toggle search-query text search-input" type="text"
                                            placeholder="Type here to search..."><span class="search-replace"></span>
                                        <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                                        <span class="caret"><!--icon--></span>
                                    </label>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">
                                                <div class="item"><i class="far fa-file-pdf bg-info"></i>PDFs</div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i
                                                        class="far fa-file-alt bg-primary"></i>Documents
                                                </div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i
                                                        class="far fa-file-excel bg-success"></i>Spreadsheet</div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i
                                                        class="far fa-file-powerpoint bg-danger"></i>Presentation</div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i class="far fa-file-image bg-warning"></i>Photos
                                                    & Images</div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i class="far fa-file-video bg-info"></i>Videos
                                                </div>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex align-items-center">

                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-label="Toggle navigation">
                            <i class="ri-menu-3-line"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto navbar-list align-items-center">
                                <li class="nav-item nav-icon search-content">
                                    <a href="#" class="search-toggle rounded" id="dropdownSearch"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-search-line"></i>
                                    </a>
                                    <div class="iq-search-bar iq-sub-dropdown dropdown-menu"
                                        aria-labelledby="dropdownSearch">
                                        <form action="#" class="searchbox p-2">
                                            <div class="form-group mb-0 position-relative">
                                                <input type="text" class="text search-input font-size-12"
                                                    placeholder="type here to search...">
                                                <a href="#" class="search-link"><i
                                                        class="las la-search"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                </li>

                                <li class="nav-item nav-icon dropdown">
                                    <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton02"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-settings-3-line"></i>
                                    </a>
                                    <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton02">
                                        <div class="card shadow-none m-0">
                                            <div class="card-body p-0 ">
                                                <div class="p-3">
                                                    <a href="#" class="iq-sub-card pt-0"><i
                                                            class="ri-settings-3-line"></i> Settings</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item nav-icon dropdown caption-content">
                                    <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton03"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <div class="caption bg-primary line-height">
                                            {{ substr(Auth::user()?->name, 0, 1) }}</div>
                                    </a>
                                    <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton03">
                                        <div class="card mb-0">
                                            <div
                                                class="card-header d-flex justify-content-between align-items-center mb-0">
                                                <div class="header-title">
                                                    <h4 class="card-title mb-0">Profile</h4>
                                                </div>
                                                <div class="close-data text-right badge badge-primary cursor-pointer ">
                                                    <i class="ri-close-fill"></i>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="profile-header">
                                                    <div class="cover-container text-center">
                                                        <div
                                                            class="rounded-circle profile-icon bg-primary mx-auto d-block">
                                                            {{ substr(Auth::user()?->name, 0, 1) }}
                                                            <a href="#">

                                                            </a>
                                                        </div>
                                                        <div class="profile-detail mt-3">
                                                            <h5><a
                                                                    href="https://templates.iqonic.design/cloudbox/html/app/user-profile-edit.html">{{ Auth::user()?->name }}</a>
                                                            </h5>
                                                            <p>{{ Auth::user()?->email }}</p>
                                                        </div>
                                                        <a href="javascript:void(0)"
                                                            onclick="if (confirm('Do you want to Logout?')){  document.getElementById('logout-form').submit();return true;}"
                                                            class="btn btn-primary">Sign
                                                            Out</a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        @yield('content')
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>

    <footer class="iq-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="privacy-policy.html">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="terms-of-service.html">Terms of Use</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 text-right">
                    <span class="mr-1">
                        <script>
                            document.write(new Date().getFullYear())
                        </script>©
                    </span> <a href="#" class="">CloudBOX</a>.
                </div>
            </div>
        </div>
    </footer>
    <script>
        const TABLE_PAGE_LENGTH = 30;
        const ASSET_URL = '{{ url('/') }}';
        const USER_STATUS = [{
            id: 1,
            name: 'Active'
        }, {
            id: 0,
            name: 'Inactive'
        }]
        var HEADER_OBJECT = {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Origin-Type": "web",
        };
    </script>
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/customizer.js') }}" defer></script>
    <script src="{{ asset('assets/js/chart-custom.js') }}" defer></script>
    <script src="{{ asset('assets/js/app.js') }}" defer></script>
    <script src="https://unpkg.com/devextreme-quill/dist/dx-quill.min.js"></script>
    <script src="{{ asset('assets/plugins/dx/js/dx.all.js') }}"></script>
    <script src="{{ asset('assets/plugins/dx/js/dx.aspnet.data.js') }}"></script>
    <script src="{{ asset('assets/plugins/dx/js/polyfill.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/dx/js/exceljs.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/dx/js/FileSaver.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    @yield('script')
</body>

</html>
