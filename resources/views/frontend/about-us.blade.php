
@extends('frontend.layouts.frontend_app')

@section('content')
@php
    $iconArray = ['fa fa-cubes', 'fa fa-line-chart', 'fa fa-pie-chart', 'fa fa-bar-chart', 'fa fa-money', 'fa fa-paper-plane'];
@endphp
<div class="main-content">

    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="images/bg/slide1.jpg">
      <div class="container pt-70 pb-20">
        <!-- Section Content -->
        <div class="section-content">
          <div class="row">
            <div class="col-md-12">
              <h2 class="title text-white">About</h2>
              <ol class="breadcrumb text-left text-black mt-10">
                <li><a class="text-gray-silver" href="{{ route('web.home') }}">Home</a></li>
                <li class="active text-gray-silver">About us</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section: About -->
    <section class="">
      <div class="container">
        <div class="section-content">
          <div class="row">
            <div class="col-md-6">
              <div class="box-hover-effect play-button">
                <div class="effect-wrapper">
                  <div class="thumb">
                    <img class="img-fullwidth" src="{{ asset($about_us-> image_link) }}" alt="project">
                  </div>
                  <div class="overlay-shade"></div>
                  <div class="text-holder text-holder-middle">
                    {{-- <a href="https://www.youtube.com/watch?v=F3QpgXBtDeo" data-lightbox-gallery="youtube-video" title="Youtube Video"><img alt="" src="images/play-button/s8.png"></a> --}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h2 class="text-uppercase mt-0 mt-sm-30">{{ $about_us-> title }}</h2>
              <h4 class="text-theme-colored">{{ $about_us-> sub_title }}</h4>
              <p>{{ $about_us -> details }}</p>
                {{-- <div class="singnature mt-20">
                  <img src="images/signature.png" alt="img1">
                </div> --}}
               <a href="#" class="btn btn-flat text-white btn-colored btn-theme-colored2 mt-15">All Blogs</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section: Service -->
    <section id="service" class="bg-lighter">
      <div class="container">
        <div class="section-title text-center">
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <h2 class="text-uppercase line-bottom-double-line-centered mt-0">Our <span class="text-theme-colored2">Services</span></h2>
              {{-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem autem voluptatem obcaecati! <br>ipsum dolor sit Rem autem voluptatem obcaecati</p> --}}
            </div>
          </div>
        </div>
        <div class="row mtli-row-clearfix">
          @foreach($service_category as $category)
          <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="service-box icon-box iconbox-theme-colored bg-white p-30 mb-30 border-1px">
              <a class="icon icon-dark border-left-theme-colored2-3px pull-left flip mb-0 mr-0 mt-5" href="{{ route('web.our_service', ['slug_name' => $category->slug_name ]) }}">
                <i class="{{ $iconArray[$loop->index] }}"></i>
              </a>
              <div class="icon-box-details">
                <h4 class="icon-box-title m-0 mb-5">{{ $category -> name }}</h4>
                <p class="text-gray mb-0">{!! Str::limit($category -> details, 50, ' ...') !!}
                </p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
  </div>
@endsection
