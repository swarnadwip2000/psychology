@extends('frontend.layouts.frontend_app')
@section('content')
    <section class="boxArea" style="min-height: 580px; height: auto;">
        <div class="container">
            <h4 class="page-head text-center mb-5">Forget Password</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <form action="{{ route('front.faculty.change.password') }}" method="POST" onsubmit="return valid()">
                            @csrf
                            <input type="hidden" name="timezone" id="timezone">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <span class="text-success">{{ Session::get('successmsg') }}</span>
                                    <span class="text-danger">{{ Session::get('errmsg') }}</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="city_name">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="city_name">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <br/>
                                <input type="submit" class="btn btn-info" value="Reset" />
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        document.getElementById('timezone').value = timezone;
    });

    </script>
@endsection
