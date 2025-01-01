@extends('frontend.layouts.student_app')
@section('content')
    <section class="dshboard p-3" style="height: 100%">
        <div class="dshboard-contain">
            <div class="container">
                <form action="{{ route('student.book_now') }}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="calender" style="margin-top: 11px">
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Check availability of the faculty ? </label>
                                    <input type="date" id="date" name="date" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="calender" style="margin-top: 11px">
                                <div class="form-group pt-3">
                                    <input type="submit" name="book_now" class="btn ton-btn w-100 mt-3" id="book_now"
                                        value="Search" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    @foreach ($teacher as $index => $val)
                        <div class="col-md-4">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ asset('user.jpeg') }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $val->name }}</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the
                                        bulk
                                        of the card's content.</p>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="{{ '#exampleModal_' . $index }}">
                                        Book Now
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="{{ 'exampleModal_' . $index }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Book Faculty</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{ route('student.faculity_booking') }}">
                                            @csrf
                                            <input type="hidden" name="teacher_id" value="{{ $val->id }}">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="formGroupExampleInput">Booking Date</label>
                                                    <select name="booking_date" id="booking_date" class="form-control"
                                                        required onchange="getbookingTime(this, {{ $val->id }})">
                                                        <option value="">Select</option>
                                                        @foreach ($val->slot as $slot)
                                                            <option value="{{ $slot->slot_date }}">{{ $slot->slot_date }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="formGroupExampleInput">Available Slot</label>
                                                    <select name="booking_time" id="booking_time_{{ $val->id }}" class="form-control booking_time"
                                                        required>
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-primary" name="save" id="save"
                                                    value="Save" />
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        function getbookingTime(option, teacherId) {
            $.ajax({
                url:"{{route('student.available_slot')}}",
                cache: false,
                data: {date: option.value, teacher_id: teacherId},
                success: function(html) {
                    console.log(html);

                    $("#booking_time_" +teacherId).html(html);
                }
            });
        }
    </script>
@endsection
