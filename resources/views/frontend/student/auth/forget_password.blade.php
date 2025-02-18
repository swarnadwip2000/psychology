@extends('frontend.layouts.frontend_app')
@section('content')
    <section class="boxArea" style="min-height: 580px; height: auto;">
        <div class="container">
            <h4 class="page-head text-center mb-5">Forget Password?</h4>
            <p class="text-center">You can reset your student password here.</p>
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <form action="{{route('front.forget.password')}}" method="POST" onsubmit="return valid()">
                            @csrf
                            <input type="hidden" name="timezone" id="timezone">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <span class="text-success">{{ Session::get('successmsg') }}</span>
                                    <span class="text-danger">{{ Session::get('errmsg') }}</span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="email">Registered Email ID</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email Address">
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
