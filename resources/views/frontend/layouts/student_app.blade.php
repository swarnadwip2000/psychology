<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>{{ $page_title }}</title>
    <link rel="stylesheet" href="{{ asset('client_assets/css/bootstrap.min.css') }}" type="text/css">

    <link rel="stylesheet" href="{{ asset('client_assets/css/owl.carousel.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client_assets/css/owl.transitions.css') }}" type="text/css">


    <script src="{{ asset('client_assets/js/jquery.min.js') }}"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link href="{{ asset('client_assets/css/custom.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('client_assets/css/asgar.css') }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

</head>

<body>
    <section id="loading">
        <div id="loading-content"></div>
    </section>
    <header class="ton_header dashboard">
        <div class="container-ton">
            <nav class="navbar navbar-expand-lg ">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
                    aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="{{ route('front.student_dashboard') }}"><span class="logo-img"><img
                            src="{{ asset('client_assets/img/logo/logo.png') }}" alt=""></span> e-Psychology</a>

                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.student_dashboard') }}"><i class="fa fa-home"
                                    aria-hidden="true"></i></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.book_now') }}">Book Faculty</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.live_class') }}">Live Class</a>
                          </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('tutorials')}}"> Tutorials </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('notes')}}">Notes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);">Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('subscription')}}"> Subscription </a>
                        </li>
                        <li class="nav-item dropdown mr-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none;">
                                <img src="{{ asset('client_assets/img/images.png') }}" alt="Profile"
                                    style="width: 28px; height: 28px; border-radius: 50%; border: 2px solid #ddd;">
                                <span class="ml-2 font-weight-bold">{{auth()->user()->name}}</span> <!-- Replace 'John Doe' dynamically -->
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="profileDropdown">
                                <a class="dropdown-item d-flex align-items-center ml-3" href="javascript:void(0);">
                                    <i class="fa fa-user-circle mr-2 text-primary"></i> Profile
                                </a>

                                <a href="{{ route('front.subscription_history')}}" class="dropdown-item d-flex align-items-center ml-3" href="javascript:void(0);">
                                    <i class="fa fa-list-alt mr-2 text-primary"></i> Subscription History
                                </a>

                                <a href="{{ route('student.logout') }}" class="m-0">
                                    <button type="button" class="dropdown-item d-flex align-items-center">
                                        <i class="fa fa-sign-out-alt mr-2 text-danger"></i> Logout
                                    </button>
                                </a>
                            </div>
                        </li>


                    </ul>
                </div>
            </nav>
        </div>
    </header>

    @yield('content')

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="menu text-center">
                        <ul>
                            <li>
                                <a href="{{ route('about.us') }}">About us</a>
                            </li>|
                            <li>
                                <a href="{{ route('articles') }}">Articles</a>
                            </li>|
                            <li>
                                <a href="{{ route('career') }}">Career</a>
                            </li>|
                            <li>
                                <a href="{{ route('help') }}">Help</a>
                            </li>|
                            <li>
                                <a href="{{ route('faq') }}">FAQ</a>
                            </li>|
                            <li>
                                <a href="{{ route('contact.us') }}">Contact us</a>
                            </li>
                        </ul>

                        <ul class="mb-3">
                            <li>
                                <a href="{{ route('blog') }}">Blog</a>
                            </li>|
                            @if (auth()->check())
                                @if (auth()->user()->hasRole('STUDENT') || auth()->user()->hasRole('FACULTY'))
                                    <!-- No additional links -->
                                @else
                                    <li>
                                        <a href="{{ route('front.faculty_login') }}">Faculty Login</a>
                                    </li>|
                                @endif
                            @else
                                <li>
                                    <a href="{{ route('front.faculty_login') }}">Faculty Login</a>
                                </li>|
                            @endif
                            <li>
                                <a href="{{ route('subscription') }}">Subscriptions</a>
                            </li>|
                            <li>
                                <a href="{{ route('terms.conditions') }}">Terms & Conditions</a>
                            </li>|
                            <li>
                                <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                            </li>
                        </ul>
                        <p>Powered By Canaeroit</p>
                    </div>
                </div>

                <div class="col-md-4 text-center">
                    <h3>FOLLOW US ON</h3>
                    <div class="d-fx-center">
                        <div class="bg-circle-outline" style="background-color:#3b5998">
                            <a href=""><i class="fa fa-2x fa-fw fa-facebook text-white"></i>
                            </a>
                        </div>
                        <div class="bg-circle-outline" style="background-color:#4099FF">
                            <a href="">
                                <i class="fa fa-2x fa-fw fa-twitter text-white"></i></a>
                        </div>

                        <div class="bg-circle-outline" style="background-color:#d34836">
                            <a href="">
                                <i class="fa fa-2x fa-fw fa-youtube-play text-white"></i></a>
                        </div>

                        <div class="bg-circle-outline" style="background-color:#0077B5">
                            <a href="">
                                <i class="fa fa-2x fa-fw fa-linkedin text-white"></i></a>
                        </div>

                        <div class="bg-circle-outline" style="background-color:#d34836">
                            <a href="">
                                <i class="fa fa-2x fa-fw fa-instagram text-white"></i></a>
                        </div>

                        <div class="bg-circle-outline" style="background-color:#d34836">
                            <a href="">
                                <i class="fa fa-2x fa-fw fa-pinterest text-white"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('client_assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('client_assets/js/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('client_assets/js/owl.carousel.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
 <script>
        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>
    @yield('script')
</body>

</html>
