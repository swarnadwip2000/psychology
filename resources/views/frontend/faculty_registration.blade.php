@extends('frontend.layouts.frontend_app')
@section('content')
    <section class="boxArea" style="min-height: 580px; height: auto;">
        <div class="container">
            <h4 class="page-head text-center mb-5"> Enter your details</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <form action="{{ route('front.faculty_registration_success') }}" method="POST" onsubmit="return valid()">
                            <input type="hidden" name="register_as" value="3">
                            @csrf()
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Full Name">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email_id">Email ID</label>
                                    <input type="text" class="form-control" id="email_id" name="email_id"
                                        placeholder="Email ID">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="password">Please Choose A Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password"
                                        name="confirm_password" placeholder="Retype Password">
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="country_name">Country Name</label>
                                    <select id="country_name" name="country_name" class="form-control">
                                        <option value="">Select</option>
                                        @foreach (config('class.allow_country') as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="city_name">City</label>
                                    <select id="city_name" name="city_name" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($city as $key => $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="degree">Degree</label>
                                    <select id="degree" name="degree" class="form-control">
                                        <option value="">Select</option>
                                        @foreach (config('class.dropdown_fuclaty_degree') as $key => $val)
                                            <option value="{{ $val['id'] }}">{{ $val['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-12 text-center">
                                <span>Login <a href="{{ route('front.faculty_login') }}">Click Here</a></span>
                                <br />
                                <input type="submit" class="btn btn-info" value="Submit" />
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
            if ($("#name").val() == '') {
                toastr.error('Enter your name!!');
                return false;
            } else if ($("#email_id").val() == '') {
                toastr.error('Enter your Email ID!!');
                return false;
            } else if ($("#password").val() == '') {
                toastr.error('Enter your password!!');
                return false;
            } else if ($("#confirm_password").val() != $("#password").val()) {
                toastr.error('Password does not match!!');
                return false;
            } else if ($("#country_name").val() == '') {
                toastr.error('Select your country name!!');
                return false;
            } else if ($("#city_name").val() == '') {
                toastr.error('Select your city name!!');
                return false;
            }else if ($("#degree").val() == '') {
                toastr.error('Select your degree!!');
                return false;
            }


        }
    </script>
@endsection
