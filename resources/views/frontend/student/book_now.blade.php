@extends('frontend.layouts.student_app')

@push('style')
    <style>
        /* Dashboard Container */
        .dshboard {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding-top: 20px;
        }

        /* Card Styling */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            width: 100%;
            height: 380px; /* Fixed height for uniformity */
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card-img-top {
            width: 100%;
            height: 180px; /* Fixed height */
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .card-body {
            text-align: center;
            padding: 15px;
            overflow: hidden;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .card-text {
            font-size: 14px;
            height: 40px; /* Set height */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .card-text:hover {
            white-space: normal;
            overflow: visible;
        }

        /* Button Styling */
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Search Form Styling */
        .search-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 12px;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .modal-footer {
            border-top: none;
        }
    </style>
@endpush

@section('content')
    <section class="">
        <div class="container">
            <!-- Search Form -->
            <div class="search-container mb-4">
                <form action="{{ route('student.book_now') }}" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="faculty_name">Search Faculty</label>
                            <input type="text" id="faculty_name" name="faculty_name" class="form-control"
                                value="{{ request('faculty_name') }}" required placeholder="Enter faculty name...">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <input type="submit" name="book_now" class="btn btn-primary w-100" id="book_now" value="Search" />
                        </div>
                    </div>
                </form>
            </div>

            <!-- Faculty Cards -->
            <div class="row">
                @foreach ($teacher as $index => $val)
                    <div class="col-md-3 mb-4">  <!-- 4 items per row -->
                        <div class="card">
                            <img src="{{ asset($val->profile_picture ? $val->profile_picture : 'client_assets/img/images.png') }}"
                                class="card-img-top" alt="Faculty Image">
                            <div class="card-body">
                                <h5 class="card-title" title="{{ $val->name }}">{{ $val->name }}</h5>
                                @if ($bio_show == true)
                                    <p class="card-text" title="{{ $val->bio }}">{!! nl2br($val->bio) !!}</p>
                                @endif

                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="{{ '#exampleModal_' . $index }}">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Modal -->
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
                                                <label for="booking_date">Booking Date</label>
                                                <select name="booking_date" id="booking_date" class="form-control"
                                                    required onchange="getbookingTime(this, {{ $val->id }})">
                                                    <option value="">Select</option>
                                                    @php
                                                        $uniqueDates = [];
                                                    @endphp

                                                    @foreach ($val->slot as $slot)
                                                        @php
                                                            $formattedDate = date('Y-m-d', strtotime($slot->slot_date_time));
                                                        @endphp

                                                        @if (!in_array($formattedDate, $uniqueDates) && \App\Helpers\SlotHelper::hasAvailableSlots($slot->slot_date_time, $val->id))
                                                            <option value="{{ $slot->slot_date_time }}">{{ $formattedDate }}</option>
                                                            @php
                                                                $uniqueDates[] = $formattedDate;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="booking_time">Available Slot</label>
                                                <select name="booking_time" id="booking_time_{{ $val->id }}" class="form-control"
                                                    required>
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
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
    </section>
@endsection

@section('script')
    <script>
        function getbookingTime(option, teacherId) {
            $.ajax({
                url: "{{ route('student.available_slot') }}",
                cache: false,
                data: { date: option.value, teacher_id: teacherId },
                success: function(html) {
                    console.log(html);
                    $("#booking_time_" + teacherId).html(html);
                }
            });
        }
    </script>
@endsection
