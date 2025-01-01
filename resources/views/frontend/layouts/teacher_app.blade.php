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
    <link href="{{ asset('client_assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="{{ asset('client_assets/js/jquery.min.js') }}"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link href="{{ asset('client_assets/css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('client_assets/css/asgar.css') }}">
</head>

<body>
    <header class="ton_header dashboard">
        <div class="container-ton">
             <nav class="navbar navbar-expand-lg ">
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <a class="navbar-brand" href="index.html"><span class="logo-img"><img src="{{ asset('client_assets/img/logo/logo.png') }}" alt=""></span> e-Psychology</a>

                      <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                          <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth_teacher_dashboard') }}"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>

                          <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth_teacher_session') }}">My Session</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Live Class</a>
                          </li>
                          <li class="nav-item">
                            <form method="POST" action="{{ route('teacher.logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-light">Logout</button>
                            </form>
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
                                <a href="about.html">About us</a>
                            </li>|
                            <li>
                                <a href="article.html">Articles</a>
                            </li>|
                            <li>
                                <a href="career.html">Career</a>
                            </li>|
                            <li>
                                <a href="help.html">Help</a>
                            </li>|
                            <li>
                                <a href="Faq.html">FAQ</a>
                            </li>|
                            <li>
                                <a href="contact.html">Contact us</a>
                            </li>
                        </ul>

                        <ul class="mb-3">
                            <li>
                                <a href="blog.html">Blog</a>
                            </li>|
                            <li>
                                <a href="{{ route('front.faculty_login') }}">Faculty Login</a>
                            </li>|
                            <li>
                                <a href="subscription.html">Subscriptions</a>
                            </li>|
                            <li>
                                <a href="terms.html">Terms & Conditions</a>
                            </li>|
                            <li>
                                <a href="privacy.html">Privacy Policy</a>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @yield('script')
</body>

</html>
