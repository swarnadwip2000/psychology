@extends('frontend.layouts.student_app')
@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

@endpush
@section('content')

    <section class="dshboard p-3">
        <div class="dshboard-contain">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">

                        <!-- Show Last Active Subscription -->
                        @if ($last_active_subscription)
                            <div class="card shadow-lg border-0 rounded-3 mb-4">
                                <div
                                    class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0"><i class="bi bi-check-circle-fill"></i> Active Subscription</h4>
                                    <h5 class="mb-0"><i class="bi bi-wallet2"></i> Available Session Tokens:
                                        {{ Auth::user()->session_token }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Subscription Details -->
                                        <div class="col-md-6">
                                            <p><strong><i class="bi bi-box-seam"></i> Plan Name:</strong>
                                                {{ $last_active_subscription->plan_name }}</p>
                                            <p><strong><i class="bi bi-cash-stack"></i> Price:</strong>
                                                {{ number_format($last_active_subscription->plan_price, 2) }}
                                                {{ strtoupper($last_active_subscription->currency) }}</p>
                                            <p><strong><i class="bi bi-clock-history"></i> Duration:</strong>
                                                {{ $last_active_subscription->plan_duration_week }} Weeks</p>
                                        </div>
                                        <!-- Dates & Status -->
                                        <div class="col-md-6">
                                            <p><strong><i class="bi bi-calendar-check"></i> Start Date:</strong>
                                                {{ \Carbon\Carbon::parse($last_active_subscription->membership_start_date)->format('d M Y') }}
                                            </p>
                                            <p><strong><i class="bi bi-calendar-x"></i> Expiry Date:</strong>
                                                {{ \Carbon\Carbon::parse($last_active_subscription->membership_expiry_date)->format('d M Y') }}
                                            </p>
                                            <p>
                                                <strong><i class="bi bi-credit-card"></i> Payment Status:</strong>
                                                @if ($last_active_subscription->payment_status == 'paid' || $last_active_subscription->payment_status == 'COMPLETED')
                                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i>
                                                        Active</span>
                                                @else
                                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i>
                                                        Expired</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                        <!-- Subscription History -->
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Subscription History</h4>
                                </div>
                            </div>
                            <div class="card-body table-fixed p-0">
                                <div class="table-responsive mt-4">
                                    <table id="subscription-history-table"
                                        class="table table-hover table-bordered text-center align-middle">
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
                                            @forelse($subscription_history as $data)
                                                <tr>
                                                    <td>{{ $data->plan_name }}</td>
                                                    <td>{{ number_format($data->plan_price, 2) }}</td>
                                                    <td>{{ $data->plan_duration_week }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($data->membership_start_date)->format('d M Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($data->membership_expiry_date)->format('d M Y') }}
                                                    </td>
                                                    <td>{{ strtoupper($data->currency) }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-primary">{{ ucfirst($data->payment_method) }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($data->payment_status == 'paid' || $data->payment_status == 'COMPLETED')
                                                            <span class="badge bg-success">Completed</span>
                                                        @else
                                                            <span class="badge bg-danger">Failed</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted">No subscription
                                                        history available.</td>
                                                </tr>
                                            @endforelse
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
    </section>

@endsection
