@php
    $slug_name = \Request::route()->parametersWithoutNulls()['slug_name'];
@endphp
@extends('frontend.layouts.frontend_app')

@section('content')
    <div class="main-content">
        <!-- Section: inner-header -->
        <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="images/bg/slide1.jpg">
            <div class="container pt-70 pb-20">
                <!-- Section Content -->
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="title text-white">Service Details</h2>
                            <ol class="breadcrumb text-left text-black mt-10">
                                <li><a class="text-white" href="{{ route('web.home') }}">Home</a></li>
                                <li><a class="text-white" href="#">Service</a></li>
                                <li class="active text-white">{{ $service?->title }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: service-->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 blog-pull-right">
                        <div class="single-service">
                            <img src="{{ asset('web_images/' . $service?->image) }}" alt="">
                            <h3 class="text-theme-colored line-bottom text-theme-colored">{{ $service?->title }}</h3>
                            <p>{!! $service?->details !!}</p>

                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="sidebar sidebar-left mt-sm-30 ml-40">
                            <div class="widget">
                                <h4 class="widget-title line-bottom">Service <span class="text-theme-colored2">List</span>
                                </h4>
                                <div class="services-list">
                                    <ul class="list list-border">
                                        @foreach ($service_category as $val)
                                            <li class="{{ $slug_name == $val->slug_name ? 'active' : '' }}"><a
                                                    href="{{ route('web.our_service', ['slug_name' => $val->slug_name]) }}">{{ $val->name }}</a>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="widget">
                                <h4 class="widget-title line-bottom">Opening <span class="text-theme-colored2">Hours</span>
                                </h4>
                                <div class="opening-hours">
                                    <ul class="list-border">
                                        <li class="clearfix"> <span> Monday :  </span>
                                          <div class="value pull-right"> 10.00 am - 07.00 pm </div>
                                        </li>
                                        <li class="clearfix"> <span> Tuesday :  </span>
                                          <div class="value pull-right"> 10.00 am - 07.00 pm </div>
                                        </li>
                                        <li class="clearfix"> <span> Wednesday :  </span>
                                          <div class="value pull-right"> 10.00 am - 07.00 pm </div>
                                        </li>
                                        <li class="clearfix"> <span> Thursday :  </span>
                                          <div class="value pull-right"> 10.00 am - 07.00 pm </div>
                                        </li>
                                        <li class="clearfix"> <span> Friday :  </span>
                                          <div class="value pull-right"> 10.00 am - 07.00 pm </div>
                                        </li>
                                        <li class="clearfix"> <span> Saturday :  </span>
                                          <div class="value pull-right"> 10.00 am - 07.00 pm </div>
                                        </li>
                                        <li class="clearfix"> <span> Sunday : </span>
                                          <div class="value pull-right"> Closed </div>
                                        </li>
                                      </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
