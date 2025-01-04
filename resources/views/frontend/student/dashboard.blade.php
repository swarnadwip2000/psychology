@extends('frontend.layouts.student_app')
@section('content')
    <section class="dshboard p-3" style="height: 700px">
        <div class="dshboard-contain">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Upcoming Meeting</h4>
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
                                                        {{ $var->date }}
                                                    </td>
                                                    <td> {{ $var->time }}</td>
                                                    <td> {{ $var->zoom_id ?? 'N/A' }} </td>
                                                    @if ($var->zoom_id)
                                                        <td><a href="{{ json_decode($var->zoom_response)->join_url ?? 'N/A' }}"
                                                                target="_blank"
                                                                class="btn btn-success">{{ $var->zoom_id ? 'Join Now' : 'Not Started' }}</a>
                                                        </td>
                                                    @else
                                                        <td><a href="javascript:void(0);"
                                                                class="btn btn-success">{{ $var->zoom_id ? 'Join Now' : 'Not Started' }}</a>
                                                        </td>
                                                    @endif

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
                                                    <td> {{ $meeting->teacher_name ?? ''}}</td>
                                                    <td>{{ date('m-d-Y', strtotime($meeting->date)) }}</td>
                                                    <td>{{ $meeting->meeting_start_time ? date('H:i A', strtotime($meeting->meeting_start_time)) : 'N/A' }}
                                                    </td>
                                                    <td>{{ $meeting->meeting_end_time ? date('H:i A', strtotime($meeting->meeting_end_time)) : 'N/A' }}
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
@endsection
