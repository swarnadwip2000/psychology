@extends('frontend.layouts.patient_app')
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
@endsection
