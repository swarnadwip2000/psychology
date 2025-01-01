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
                            <h2 class="title text-white">Blog</h2>
                            <ol class="breadcrumb text-left text-black mt-10">
                                <li><a class="text-white" href="{{ route('web.home') }}">Home</a></li>
                                <li><a class="text-white" href="#">Blog</a></li>
                                <li class="active text-white">{{ \Request::route()->parametersWithoutNulls()['slug_name'] }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: News & Blog -->
        <section id="news">
            <div class="container">
                <div class="section-content">
                    <div class="row">
                        @foreach($blog as $val)
                        <div class="col-sm-6 col-md-4">
                            <article class="post clearfix mb-30 mb-sm-30">
                                <div class="entry-header">
                                    <div class="post-thumb thumb">
                                        <img src="{{ asset('web_images/'.$val->image) }}" alt="" class="img-responsive img-fullwidth">
                                    </div>
                                </div>
                                <div class="entry-content p-20 pr-10 bg-lighter">
                                    <div class="entry-meta media mt-0 no-bg no-border">
                                        <div
                                            class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
                                            <ul>
                                                <li class="font-16 text-white font-weight-600 border-bottom">{{ date('d', strtotime($val->created_at)) }}</li>
                                                <li class="font-12 text-white text-uppercase">{{ date('M', strtotime($val->created_at)) }}</li>
                                            </ul>
                                        </div>
                                        <div class="media-body pl-15">
                                            <div class="event-content pull-left flip">
                                                <h4 class="entry-title text-white text-uppercase m-0 mt-5"><a
                                                        href="#">{{ $val->title }}</a></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-10">{!! Str::limit($val->details, 100, ' ...') !!}</p>
                                    <a class="btn btn-theme-colored2 btn-sm text-white"
                                        href="{{ route('web.our_blog_details', ['slug_name' => $val->slug_name]) }}"> View Details</a>
                                    <div class="clearfix"></div>
                                </div>
                            </article>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
