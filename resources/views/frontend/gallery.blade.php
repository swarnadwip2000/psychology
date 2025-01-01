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
                            <h2 class="title text-white">About</h2>
                            <ol class="breadcrumb text-left text-black mt-10">
                                <li><a class="text-gray-silver" href="{{ route('web.home') }}">Home</a></li>
                                <li class="active text-gray-silver">Gallery</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Grid 3 -->
        <section>
            <div class="container">
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Portfolio Filter -->

                            <!-- End Portfolio Filter -->

                            <!-- Portfolio Gallery Grid -->
                            <div class="gallery-isotope default-animation-effect grid-4 gutter-small clearfix"
                                data-lightbox="gallery">


                                @foreach ($galleries as $list)
                                    <div class="gallery-item pl-5">
                                        <div class="box-hover-effect">
                                            <div class="effect-wrapper">
                                                <div class="thumb">
                                                    <img class="img-fullwidth" src="{{ $list->image_link }}" alt="project">
                                                </div>
                                                <div class="overlay-shade"></div>
                                                <div class="text-holder text-holder-middle">
                                                    <div class="title text-center">
                                                        {{-- <h4 class="text-uppercase text-white mb-0">consumer insights</h4>
                                      <p class="text-gray-darkgray mt-5">We help business improve</p> --}}
                                                    </div>
                                                </div>
                                                <div class="icons-holder icons-holder-bottom-right">
                                                    <div class="icons-holder-inner">
                                                        <div
                                                            class="styled-icons icon-sm icon-dark icon-circled icon-theme-colored">
                                                            <a href="{{ $list->image_link }}"
                                                                data-lightbox-gallery="gallery1" title="Your Title Here"><i
                                                                    class="fa fa-camera"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="hover-link" data-lightbox-gallery="gallery1-link"
                                                    href="{{ $list->image_link }}">View more</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- End Portfolio Gallery Grid -->

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
