@extends('frontend.layouts.teacher_app')
@section('title')
    {{ ucwords(str_replace('_', ' ', env('APP_NAME'))) }}
@endsection
@section('content')
    <section class="dshboard p-3" style="height: 700px">
        <div class="dshboard-contain">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                          <div class="card-header d-flex justify-content-between">
                              <div class="header-title">
                                <h4 class="card-title">Booking History</h4>
                              </div>
                          </div>
                          <div class="card-body table-fixed p-0">
                            <div class="table-responsive mt-4">
                                <table id="basic-table" class="table table-striped mb-0" role="grid">
                                  <thead>
                                      <tr>
                                        <th>Student Name</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Metting Id</th>
                                        <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($booking_slot as $booking)
                                      <tr>
                                        <td>
                                           {{ $booking->student->name }}
                                        </td>
                                        <td>
                                            {{ date('d-m-Y', strtotime($booking->date)) }}
                                        </td>
                                        <td> {{ $booking->time }}</td>

                                        <td>{{ $booking ->zoom_id??'N/A' }}</td>
                                        <td>
                                         @if($booking ->zoom_id)
                                           <a href="{{ route('teacher_live_class', ['meeting_id' => $booking ->zoom_id]) }}" class="btn btn-success">Join Now</a>
                                         @else
                                         <a href="javascript:void(0)" onclick="getbookingTime({{ $booking->id }})" class="btn btn-success">Start Call</a>
                                         @endif
                                        </td>
                                      </tr>
                                      @endforeach
                                  </tbody>
                                </table>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@section('script')
    @routes
    <script>
        function getbookingTime(bookingId) {
            $.ajax({
                url: "{{route('start_new_meeting')}}",
                cache: false,
                data: {booking_id: bookingId},
                success: function(html) {
                    $("#booking_time").html(html);
                }
            });
        }
    </script>
@endsection
