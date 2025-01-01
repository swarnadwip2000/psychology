@extends('frontend.layouts.frontend_app')
@section('content')
<section class="page-banner">
  <div class="container">
        <div class="banner-in">
              <div class="banner-text">
                  <h4 class="banner-head">Learn <span>Psychology</span>  with best Teachers across the world.</h4>
                  <h4 class="banner-sub-head">Quick way to learn Psychology</h4>

                  <div class="banner-button mt-5">
                            <a href="{{ route('front.school_registration') }}" class="btn ton-btn" style="width: 110px;">School</a>
                            <a href="{{ route('front.college_registration') }}" class="btn ton-btn" style="width: 110px;">College</a>
                  <a href="dashboard-review.html" class="button-text">Reviews & Testimonials</a>
                  </div>
              </div>

        </div>
  </div>
</section>
@endsection
