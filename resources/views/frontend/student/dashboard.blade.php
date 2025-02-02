@extends('frontend.layouts.student_app')
@section('content')
    @php
        use App\Helpers\SlotHelper;
    @endphp
    <section class="dshboard p-3" style="">
        <div class="dshboard-contain">
            <div class="container">
                <p style="    font-weight: bold;
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
                                    <h4 class="card-title">Upcoming Meeting</h4> <span></span>
                                </div>
                            </div>
                            <div class="card-body table-fixed p-0">
                                <div class="table-responsive mt-4">
                                    <table id="basic-table" class="table table-striped mb-0" role="grid">
                                        <thead>
                                            <tr>
                                                <th>Topic</th>
                                                <th>Faculty Name</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Meeting Id</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($teacher as $var)
                                                <tr>
                                                    <td>
                                                        {{ $var->slot->topic }}
                                                    </td>
                                                    <td>
                                                        {{ $var->teacher_name }}
                                                    </td>
                                                    <td>
                                                        {{ $var->date ? \App\Helpers\TimeHelper::convertToUserDate($var->date . ' ' . $var->time, auth()->user()->time_zone, $var->teacher->time_zone) : 'N/A' }}
                                                    </td>

                                                    <td>
                                                        {{ $var->time ? \App\Helpers\TimeHelper::convertToUserTime($var->date . ' ' . $var->time, auth()->user()->time_zone, $var->teacher->time_zone) : 'N/A' }}
                                                    </td>


                                                    <td> {{ $var->zoom_id ?? 'N/A' }} </td>
                                                    <td id="booking-row-{{ $var['id'] }}">
                                                        @if ($var->zoom_id && $var->meeting_status != 2)
                                                            <a href="{{ json_decode($var->zoom_response)->join_url ?? 'javascript:void(0);' }}"
                                                                class="btn btn-success"
                                                                target="_blank">{{ $var->zoom_id ? 'Rejoin' : 'Rejoin' }}</a>
                                                        @else
                                                            <a href="javascript:void(0)"
                                                                onclick="getbookingTime({{ $var->id }})"
                                                                class="btn btn-success start-call-btn">Join Now</a>
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
                                                <th>Faculty Name</th>
                                                <th>Meeting Date (mm-dd-yyyy)</th>
                                                <th>Meeting Time</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Duration</th> <!-- New column for meeting duration -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($booking_history as $meeting)
                                                <tr>
                                                    <td>{{ $meeting->slot->topic ?? '' }}</td>
                                                    <td> {{ $meeting->teacher_name ?? '' }}</td>
                                                    <td>
                                                        {{ $meeting->date ? \App\Helpers\TimeHelper::convertToUserDate($meeting->date . ' ' . $meeting->time, auth()->user()->time_zone, $meeting->teacher->time_zone) : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        {{ $meeting->time ? \App\Helpers\TimeHelper::convertToUserTime($meeting->date . ' ' . $meeting->time, auth()->user()->time_zone, $meeting->teacher->time_zone) : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        {{ $meeting->meeting_start_time ? \App\Helpers\TimeHelper::convertToUserTime($meeting->meeting_start_time, auth()->user()->time_zone, $meeting->teacher->time_zone) : 'N/A' }}
                                                    </td>

                                                    <td>
                                                        {{ $meeting->meeting_end_time ? \App\Helpers\TimeHelper::convertToUserTime($meeting->meeting_end_time, auth()->user()->time_zone, $meeting->teacher->time_zone) : 'N/A' }}
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
    <script>
        function getbookingTime(bookingId) {
            $('#loading').addClass('loading');
            $('#loading-content').addClass('loading-content');

            $.ajax({
                url: "{{ route('student.start_new_meeting') }}",
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
    </script>
@endsection
