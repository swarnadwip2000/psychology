@extends('frontend.layouts.frontend_app')
@section('content')
    <section class="payment-page d-flex-center">
        <br>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3>This is an under-construction payment gateway page</h3>
                    <h4> Payment will be processed herein </h4>
                </div>
                <br>
                <div class="col-md-12 text-center">
                    <img class="pay-img" src="{{ asset('client_assets/img/pay1.png') }}" alt="">
                    <br><br>
                </div>

                <div class="col-md-6 text-right scss-fail-btn"><a class="btn ton-btn" href="{{ route('front.student_dashboard') }}">Click here to
                        simulate SUCCESS</a></div>
                <div class="col-md-6 text-left scss-fail-btn"><a class="btn ton-btn black" href="{{ route('front.subscriptions') }}">Click
                        here to Simulate FAILURE</a></div>
            </div>
        </div>
    </section>
@endsection
@section('script')
@endsection
