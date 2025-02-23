@extends('frontend.layouts.student_app')
@push('style')
<style>
    .price-table {
    border: 2px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    position: relative;
    transition: all 0.3s ease;
}

.price-table.active-plan {
    border-color: #28a745;
    box-shadow: 0 0 10px rgba(40, 167, 69, 0.5);
}

.active-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #28a745;
    color: white;
    padding: 5px 10px;
    font-size: 12px;
    border-radius: 5px;
}

</style>
@endpush
@section('content')
    <section>
        <div class="priceOfclass">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-11 text-center">
                        <div class="backSide">

                            <div class="topArea">
                                <h3>Get Premium Access To <span>Psychology Classes</span>
                                    <span class="skip"><a class="" href="payment.html"> </a></span>
                                </h3>

                            </div>

                            <div class="row">
                                @php
                                $activePlanId = \App\Helpers\Helper::getActiveSubscriptionPlanId();
                            @endphp

                            @if (count($plans) > 0)
                                @foreach ($plans as $plan)
                                    <div class="col-sm-4">
                                        <div class="price-table {{ $activePlanId == $plan->id ? 'active-plan' : '' }}">
                                            <div class="price-head">
                                                <h4>{{ $plan->plan_name }}</h4>
                                                <h5>{{ $plan->plan_duration_week }} Weeks</h5>
                                            </div>
                                            <div class="price-content">
                                                <ul>
                                                    <li><span>CA$</span>{{ $plan->plan_price }}</li>
                                                    <li>{!! nl2br($plan->plan_description) !!}</li>
                                                </ul>
                                            </div>
                                            <div class="price-button">
                                                @if ($plan->plan_price != 0)
                                                <a href="{{ route('student.subscription.payment', $plan->id) }}">Select</a>
                                                
                                                @endif

                                                <p>{{ $plan->plan_price == 0 ? 'Free' : '$' . $plan->plan_price }}</p>
                                            </div>
                                            @if ($activePlanId == $plan->id)
                                                <div class="active-badge">Active Plan</div>
                                            @endif
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
