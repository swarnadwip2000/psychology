@extends('frontend.layouts.teacher_app')
@section('content')

  <section class="" style="height: ">
  <div class="dshboard-contain">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h5 class="video-heading">Live Video Tutorial</h5>

            <iframe src="{{ "https://zoom.us/wc/".$meeting->zoom_id."/join?pwd=".$meeting->password."&un='sankar Bera'&prefer=1" }}"   allowfullscreen="false"
                frameborder="0" width="100%" height="500px"></iframe>

        </div>
        {{-- <div class="col-md-4">
          <div class="calender pt-5">
            <h5 class="video-heading">To begin your class, please enter your access code  </h5>
            <input type="text" name="password" value="{{ $meeting->password??null }}">
            <div class="form-group">
              <!-- <label for="formGroupExampleInput">Change date or time ? </label>
                <input type="datetime-local" id="" name="" class="form-control">
                <a href="" class="btn ton-btn w-100 mt-3">Check availability of the faculty</a> -->

                <h6>Next class Date : <a href="">{{ $meeting -> start_time??'No Schedule' }}</a></h6>
                <h6>Time : <a href="">{{ $meeting?->start_time?date('H:i', strtotime($meeting -> start_time)):'No Schedule' }}</a></h6>
                <h6>Faculty : <a href="">{{ $meeting?->teacher?->name  }}</a></h6>
                <p>Kindly enter the access code atleast 5 minutes prior to start of the class
                </p>
                 @if($meeting?->join_link)<a href="{{ $meeting?->join_link }}">Join Now</a>@endif
                <p>Trouble in attending class, pls email at</p>
            </div>
          </div>
        </div> --}}
        </div>
        <br>
      </div>
  </div>
  </div>
</section>

@endsection
@push('script')
@endpush
