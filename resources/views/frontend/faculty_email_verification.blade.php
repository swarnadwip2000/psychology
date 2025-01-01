@extends('frontend.layouts.frontend_app')
@section('content')
    <section>
        <div class="boxArea-3">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <h3>Welcome to the class of <span>Psychology</span></h3>
                        <h5>Thanks for joining us ! <span>Kindly confirm your email by clicking on the Button.</span> </h5>

                        <div class="text-center">
                            <a href="{{ route('front.faculty_login') }}" class="btn ton-btn">Confirm my email</a>

                            <p class="mt-3 last">Please confirm your account by clicking on the link we've just sent to the
                                email address provided. </p>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
@section('script')
@endsection
