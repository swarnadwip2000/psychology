@extends('frontend.layouts.frontend_app')
@section('content')
    <section class="boxArea" style="min-height: 580px; height: auto;">
        <div class="container">
            <h4 class="page-head text-center mb-5">Change your Password</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <form action="{{ route('front.change.password') }}" method="POST" onsubmit="return valid()">
                            @csrf
                            <input type="hidden" name="timezone" id="timezone">
                            <input type="hidden" name="id" value="{{ $id }}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <span class="text-success">{{ Session::get('successmsg') }}</span>
                                    <span class="text-danger">{{ Session::get('errmsg') }}</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="city_name">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="city_name">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password"
                                        name="confirm_password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <br />
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
            var password = $("#password").val();
            var confirmPassword = $("#confirm_password").val();

            if (password == '') {
                toastr.error('Enter your password!');
                return false;
            } else if (confirmPassword == '') {
                toastr.error('Enter your confirm password!');
                return false;
            } else if (password !== confirmPassword) {
                toastr.error('Passwords do not match!');
                return false;
            } else if (password.length < 6) {
                toastr.error('Password must be at least 6 characters long!');
                return false;
            }

            return true;
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            document.getElementById('timezone').value = timezone;
        });
    </script>
@endsection
