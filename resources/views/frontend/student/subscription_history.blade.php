@extends('frontend.layouts.student_app')
@section('content')
<section class="dshboard p-3" style="">
    <div class="dshboard-contain">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Subscription History</h4> <span></span>
                            </div>
                        </div>
                        <div class="card-body table-fixed p-0">
                            <div class="table-responsive mt-4">
                                <table id="subscription-history-table" class="table table-hover table-bordered text-center align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Plan Name</th>
                                            <th>Plan Price</th>
                                            <th>Plan Duration (Weeks)</th>
                                            <th>Start Date</th>
                                            <th>Expiry Date</th>
                                            <th>Currency</th>
                                            <th>Payment Method</th>
                                            <th>Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subscription_history as $data)
                                            <tr>
                                                <td>{{ $data->plan_name }}</td>
                                                <td>{{ number_format($data->plan_price, 2) }}</td> <!-- Formats price to 2 decimal places -->
                                                <td>{{ $data->plan_duration_week }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->membership_start_date)->format('d M Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->membership_expiry_date)->format('d M Y') }}</td>
                                                <td>{{ strtoupper($data->currency) }}</td>
                                                <td>
                                                    <span class="badge bg-primary">{{ ucfirst($data->payment_method) }}</span>
                                                </td>
                                                <td>
                                                    @if($data->payment_status == 'paid')
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif($data->payment_status == 'COMPLETED')
                                                        <span class="badge bg-success">Completed</span>
                                                    @else
                                                        <span class="badge bg-danger">Failed</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="pagination-container mt-2 d-flex justify-content-center">
                                    {{ $subscription_history->links() }}
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
