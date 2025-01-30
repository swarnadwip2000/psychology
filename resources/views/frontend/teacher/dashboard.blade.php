@extends('frontend.layouts.teacher_app')
@section('title')
    {{ ucwords(str_replace('_', ' ', env('APP_NAME'))) }}
@endsection
@section('content')
    <section class="dshboard p-3" style="height: 700px">
        <div class="dshboard-contain">
            <div class="container">
                <p
                    style="    font-weight: bold;
                background: #bff37e45;
                font-size: 19px;
            }">

                    <span>Note: Each session is currently limited to a maximum of 40 minutes.</span>
                </p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Upcoming Meeting</h4><span></span>
                                </div>
                            </div>
                            <div class="card-body table-fixed p-0">
                                <div class="table-responsive mt-4">
                                    <table id="basic-table" class="table table-striped mb-0" role="grid">
                                        <thead>
                                            <tr>
                                                <th>Topic</th>
                                                <th>Student Name</th>
                                                <th>Date (mm-dd-yyy)</th>
                                                <th>Time</th>
                                                <th>Meeting Id</th>
                                                {{-- <th>Meeting Password</th> --}}
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($booking_slot as $booking)
                                                <tr>
                                                    <td>
                                                        {{ $booking->slot->topic }}
                                                    </td>
                                                    <td>
                                                        {{ $booking->student->name }}
                                                    </td>
                                                    <td>
                                                        {{ date('m-d-Y', strtotime($booking->date)) }}
                                                    </td>
                                                    <td> {{ date('H:i', strtotime($booking->time)) }}</td>

                                                    <td>{{ $booking->zoom_id ?? 'N/A' }}</td>

                                                    {{-- <td>
                                                        {{ json_decode($booking->zoom_response)->password ?? 'N/A' }}
                                                    </td> --}}
                                                    <td id="booking-row-{{ $booking->id }}">
                                                        @if ($booking->zoom_id && $booking->meeting_status != 2)
                                                            <a href="{{ json_decode($booking->zoom_response)->join_url ?? 'N/A' }}"
                                                                class="btn btn-success" target="_blank">Rejoin</a>
                                                            <a href="javascript:void(0)"
                                                                onclick="endMeeting({{ $booking->id }})"
                                                                class="btn btn-danger">End Call</a>
                                                        @elseif ($booking->zoom_id && $booking->meeting_status == 2)
                                                            <span class="btn btn-secondary" disabled>Meeting Ended</span>
                                                        @else
                                                            <a href="javascript:void(0)"
                                                                onclick="getbookingTime({{ $booking->id }})"
                                                                class="btn btn-success start-call-btn">Start Call</a>
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

                    <div class="col-md-12 mt-5">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Past Meeting History</h4>
                                </div>
                            </div>
                            <div class="card-body table-fixed p-0">
                                <div class="table-responsive mt-4">
                                    <table id="basic-table" class="table table-striped mb-0" role="grid">
                                        <thead>
                                            <tr>
                                                <th>Topic</th>
                                                <th>Student Name</th>
                                                <th>Date (mm-dd-yyyy)</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Duration</th> <!-- New column for meeting duration -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($booking_history as $meeting)
                                                <tr>
                                                    <td>{{ $meeting->slot->topic ?? '' }}</td>
                                                    <td>{{ $meeting->student->name ?? '' }}</td>
                                                    <td>{{ date('m-d-Y', strtotime($meeting->date)) }}</td>
                                                    <td>{{ $meeting->meeting_start_time ? date('H:i', strtotime($meeting->meeting_start_time)) : 'N/A' }}
                                                    </td>
                                                    <td>{{ $meeting->meeting_end_time ? date('H:i', strtotime($meeting->meeting_end_time)) : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if ($meeting->meeting_start_time && $meeting->meeting_end_time)
                                                            <?php
                                                            // Calculate duration using Carbon
                                                            $start = \Carbon\Carbon::parse($meeting->meeting_start_time);
                                                            $end = \Carbon\Carbon::parse($meeting->meeting_end_time);
                                                            $duration = $start->diff($end); // Get the difference between start and end times
                                                            ?>
                                                            {{ $duration->format('%h hours %i minutes') }}
                                                            <!-- Format the duration as hours and minutes -->
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- Pagination Links -->
                                    <div class="pagination-container mt-2 d-flex justify-content-center">
                                        {{ $booking_history->links() }}
                                    </div>

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
            $('#loading').addClass('loading');
            $('#loading-content').addClass('loading-content');

            $.ajax({
                url: "{{ route('start_new_meeting') }}",
                cache: false,
                data: {
                    booking_id: bookingId
                },
                success: function(data) {
                    $('#loading').removeClass('loading');
                    $('#loading-content').removeClass('loading-content');

                    if (data.status === false) {
                        toastr.error(data.message);
                    } else {
                        // Open the meeting in a new tab
                        window.open(data.start_url, '_blank');

                        // Update the buttons dynamically
                        const bookingRow = $(`#booking-row-${bookingId}`);
                        bookingRow.html(`
                    <a href="${data.start_url}" class="btn btn-success" target="_blank">Rejoin</a>
                    <a href="javascript:void(0)" onclick="endMeeting(${bookingId})" class="btn btn-danger">End Call</a>
                `);
                    }
                },
                error: function() {
                    $('#loading').removeClass('loading');
                    $('#loading-content').removeClass('loading-content');
                    toastr.error('An error occurred while starting the meeting.');
                }
            });
        }


        function endMeeting(bookingId) {
            $('#loading').addClass('loading');
            $('#loading-content').addClass('loading-content');
            // AJAX request to the server to end the meeting
            $.ajax({
                url: "{{ route('end_new_meeting') }}", // Define the correct route in your routes/web.php
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Ensure CSRF token is included
                    booking_id: bookingId
                },
                success: function(response) {
                    $('#loading').removeClass('loading');
                    $('#loading-content').removeClass('loading-content');
                    location.reload(); // Or update the button text to 'Meeting Ended' without page reload
                }
            });
        }
    </script>
@endsection
