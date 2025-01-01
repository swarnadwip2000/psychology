@extends('frontend.layouts.frontend_app')
@section('content')
    <section>
        <div class="priceOfclass">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-11 text-center">
                        <div class="backSide">

                            <div class="topArea">
                                <h3>Get Premium Access To <span>Psychology Classes</span>
                                    <span class="skip"><a class="" href="{{ route('front.payment') }}"> Skip it for now</a></span>
                                </h3>

                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="price-table">
                                        <div class="price-head">
                                            <h4>Individual Classes</h4>
                                            <h5>3 months</h5>
                                        </div>
                                        <div class="price-content">
                                            <ul>
                                                <li><span>CA$</span>99<span>.99</span></li>
                                                <li> per months</li>
                                                <li> 4 Days per week</li>
                                            </ul>
                                        </div>
                                        <div class="price-button">
                                            <a href="{{ route('front.payment') }}">Select</a>
                                            <p> ₹ 6000 </p>
                                        </div>
                                    </div>
                                </div>




                                <div class="col-sm-4">
                                    <div class="price-table">
                                        <div class="price-head">
                                            <h4>Group Classes</h4>
                                            <h5> 4 months </h5>
                                        </div>
                                        <div class="price-content">
                                            <ul>
                                                <li><span>CA$</span>79<span>.99</span></li>
                                                <li>per month</li>
                                                <li>incl. Sample paper</li>
                                            </ul>
                                        </div>
                                        <div class="price-button">
                                            <a href="{{ route('front.payment') }}" class="active">Select</a>
                                            <p>₹ 5000</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="price-table">
                                        <div class="price-head">
                                            <h4>Group Classes</h4>
                                            <h5>6 month</h5>
                                        </div>
                                        <div class="price-content">
                                            <ul>
                                                <li><span>CA$</span>49<span>.99</span></li>
                                                <li>per month</li>
                                                <li>2 Days Per Week</li>
                                            </ul>
                                        </div>
                                        <div class="price-button">
                                            <a href="{{ route('front.payment') }}">Select</a>
                                            <p>₹ 3000</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
@endsection
