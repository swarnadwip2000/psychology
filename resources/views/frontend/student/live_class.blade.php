@extends('frontend.layouts.student_app')
@section('content')
    <section class="" style="">
        <div class="dshboard-contain">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="video-heading">Live Video Tutorial</h5>
                        {{-- @if ($data)
                            <iframe
                                src="{{ 'https://zoom.us/wc/' . $meeting->zoom_id . '/join?pwd=' . $meeting->password . "&un='sankar Bera'&prefer=1" }}"
                                allow="camera; microphone; display-capture" allowfullscreen="false" frameborder="0"
                                width="100%" height="500px"></iframe>
                        @endif --}}
                        <div id="zmmtg-root"></div>
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
                 @if ($meeting?->join_link)<a href="{{ $meeting?->join_link }}">Join Now</a>@endif
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
@section('script')
    <script>
        setTimeout(() => {
            $(document).on('click', '.leave-meeting-options__btn', function() {
                alert('Button clicked!');
            });
        }, 1500);
        // Use event delegation to listen for clicks on dynamically added elements
    </script>
    <!-- Dependencies for client view and component view -->
    <script src="https://source.zoom.us/3.1.0/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/3.1.0/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/3.1.0/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/3.1.0/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/3.1.0/lib/vendor/lodash.min.js"></script>

    <!-- Choose between the client view or component view: -->
    <script src="https://source.zoom.us/zoom-meeting-3.1.0.min.js"></script>

    <script>
        ZoomMtg.preLoadWasm()
        ZoomMtg.prepareWebSDK()

        var sdkKey = "{{ $sdkKey }}";
        var signature = "{{ $signature }}";
        var meetingNumber = "{{ $meetingNumber }}";
        var passWord = "{{ $password }}";
        var userName = "{{ $userName }}";
        var zakToken = "{{ $zakToken ?? '' }}";

        ZoomMtg.init({
            leaveUrl: "https://example.com/thanks-for-joining",
            success: (success) => {
                ZoomMtg.join({
                    sdkKey: sdkKey,
                    signature: signature,
                    meetingNumber: meetingNumber,
                    passWord: passWord,
                    userName: userName,
                    // zak: zakToken,
                    success: (success) => {
                        console.log(success);
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })
            },
            error: (error) => {
                console.log(error);
            }
        })
    </script>

@endsection
