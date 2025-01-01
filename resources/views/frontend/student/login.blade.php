@extends('frontend.layouts.frontend_app')
@section('content')
    <section class="boxArea" style="min-height: 580px; height: auto;">
        <div class="container">
            <h4 class="page-head text-center mb-5"> Enter your details</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <form action="{{ route('front.student_login_success') }}" method="POST" onsubmit="return valid()">
                            @csrf()
                            <div class="row">
                                <div class="form-group col-md-12">
                                <span class="text-success">{{ Session::get('successmsg') }}</span>
                                <span class="text-danger">{{ Session::get('errmsg') }}</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="student_class">Registered Email ID</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email Address">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="city_name">Enter Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <span>Create a New Account <a href="{{ route('front.home') }}">Click Here</a></span>
                                <br/>
                                <input type="submit" class="btn btn-info" value="Login" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        function valid() {
            if($("#email").val() == ''){
                toastr.error('Enter your email id!!');
                return false;
            }else if($("#password").val() == ''){
                toastr.error('Enter your password!!');
                return false;
            }
        }
    </script>
@endsection
