<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ ucwords(str_replace('_', ' ', env('APP_NAME', 'Document Sharing'))) }}: Login</title>
    <link rel="shortcut icon" href="https://templates.iqonic.design/cloudbox/html/assets/images/favicon.ico" />
    <link rel="stylesheet" href="{{ asset('assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/backende209.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/fonts/remixicon.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
</head>
<body class=" ">
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <div class="wrapper">
        <section class="login-content">
            <div class="container h-100">
                <div class="row justify-content-center align-items-center height-self-center">
                    <div class="col-md-5 col-sm-12 col-12 align-self-center">
                        <div class="sign-user_card">
                            <img src="../assets/images/logo.png" class="img-fluid rounded-normal light-logo logo"
                                alt="logo">
                            <img src="../assets/images/logo-white.png"
                                class="img-fluid rounded-normal darkmode-logo logo" alt="logo">
                            <h3 class="mb-3">Sign In</h3>
                            <p>Login to stay connected.</p>
                            <form method="POST" action="{{ route('admin_login_submit') }}" onsubmit="return validation()">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control" id="email" type="email" placeholder=" " name="email" value="{{ old('email') }}">
                                            <label>Email<span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control" type="password" placeholder=" " name="password" id="password">
                                            <label>Password<span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="custom-control custom-checkbox mb-3 text-left">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="auth-recoverpw.html" class="text-primary float-right">Forgot
                                            Password?</a>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="{{ asset('assets/js/backend-bundle.min.js') }}"></script>
    <script src=" {{ asset('assets/js/customizer.js') }}" defer></script>
    <script src="{{ asset('assets/js/chart-custom.js') }}" defer></script>
    <script src="{{ asset('assets/js/app.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

</body>
<script>
    function validation(){
        if($("#email").val() == ''){
            toastr.error("Email id is a required field");
            return false;
        }else if($("#password").val() == ''){
            toastr.error("Password is a required field");
            return false;
        }
    }
</script>
</html>
