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
              <span class="skip"><a class="" href="payment.html"> </a></span></h3>

          </div>

           <div class="row">
            @if (count($plans) > 0)
            @foreach ($plans as $key => $plan)
            <div class="col-sm-4">
              <div class="price-table">
                 <div class="price-head">
                      <h4>{{ $plan->plan_name }}</h4>
                       <h5>{{ $plan->plan_duration }} days</h5>
                 </div>
                 <div class="price-content">
                  <ul>
                    <li><span>CA$</span>{{ $plan->plan_price }}</li>
                    <li></li>
                    <li> {!! nl2br($plan->plan_description) !!} </li>
                  </ul>
                 </div>
                 <div class="price-button">
                  <a href="{{ route('front.payment', $plan->id) }}">Select</a>
                  <p> $ {{ $plan->plan_price }}</p>
                 </div>
              </div>
            </div>
            @endforeach
              @else
              <div class="col-md-12 text-center">
                <h4>No Plan Found</h4>
              </div>
            @endif

            </div>
  <br>

         </div>
         </div>
        </div>
      </div>
     </div>
   </section>
@endsection
