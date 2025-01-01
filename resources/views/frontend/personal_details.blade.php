@extends('frontend.layouts.frontend_app')
@section('content')
    <section class="boxArea" style="min-height: 580px; height: auto;">
        <div class="container">
            <h4 class="page-head text-center mb-5"> Enter your details</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <form action="{{ route('front.registration_success') }}" method="POST" onsubmit="return valid()">
                            <input type="hidden" name="row_id" value="{{ $id }}">
                            @csrf()
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">What's Your Name?</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="student_class">What Is Your Email Address?</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email Address">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="city_name">Please Choose A Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="city_name">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Retype Password">
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <span>By Registering, I accept the <a href="#">Terms and Conditions</a> and the <a href="#">Privacy policy</a></span></a>
                                <br/>
                                <input type="submit" class="btn btn-info" value="Next" />
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
            if($("#name").val() == ''){
                toastr.error('Enter your full name!!');
                return false;
            }else if($("#email").val() == ''){
                toastr.error('Enter your email id!!');
                return false;
            }else if($("#password").val() == ''){
                toastr.error('Enter your password!!');
                return false;
            }else if($("#confirm_password").val() == ''){
                toastr.error('Password does not match!!');
                return false;
            }
        }
    </script>
@endsection
