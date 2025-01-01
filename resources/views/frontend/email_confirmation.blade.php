@extends('frontend.layouts.frontend_app')
@section('content')
    <section>
        <div class="boxArea-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <div class="text-center py-4"><img src="{{ asset('client_assets/img/boxArea-4/e1.png') }}" width="150"></div>
                        <h3>Email Confirmed</h3>
                        <h5>Thanks for confirming your email address.<br>let's start learning!</h5>
                        <div class="text-center">
                            {{-- @dd($type) --}}
                            @if ($type == 'teacher')
                            <a href="{{ route('front.faculty_login') }}" class="btn ton-btn w-50">Start</a>

                            @else
                            <a href="{{ route('front.student_login') }}" class="btn ton-btn w-50">Start</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
@section('script')
@endsection
