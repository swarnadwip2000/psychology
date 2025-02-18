@extends('admin.layouts.master')
@section('title')
    Plans Details - {{ env('APP_NAME') }}
@endsection
@push('styles')
    <style>
        .dataTables_filter {
            margin-bottom: 10px !important;
        }
    </style>
@endpush
@section('head')
    Plans Details
@endsection
@section('create_button')
    {{-- <a href="{{route('plans.create')}}" id="create-state" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_admin">Add
        Plan</a> --}}
@endsection
@section('content')
    <section id="loading">
        <div id="loading-content"></div>
    </section>
    <div class="main-content">
        <div class="inner_page">

            <div class="card table_sec stuff-list-table">
                <div class="row justify-content-end">
                    <div class="col-md-6">
                        <div class="row g-1 justify-content-end">
                            {{-- <div class="col-md-8 pr-0">
                                <div class="search-field prod-search">
                                    <input type="text" name="search" id="search" placeholder="search..." required
                                        class="form-control">
                                    <a href="javascript:void(0)" class="prod-search-icon"><i
                                            class="ph ph-magnifying-glass"></i></a>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-3 pl-0 ml-2">
                                <button class="btn btn-primary button-search" id="search-button"> <span class=""><i
                                            class="ph ph-magnifying-glass"></i></span> Search</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="plans" class="dd table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Plan Name</th>
                                <th>Price</th>
                                <th>Duration (Weeks)</th>
                                <th>Video Sessions</th>
                                <th>Free Tutorial</th>
                                <th>Free Notes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($plans->count() > 0)
                                @foreach ($plans as $key => $plan)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $plan->plan_name }}</td>
                                        <td>${{ number_format($plan->plan_price, 2) }}</td>
                                        <td>{{ $plan->plan_duration_week }} Weeks</td>
                                        <td>{{ $plan->session }}</td>
                                        <td>{{ $plan->free_tutorial ? 'Yes' : 'No' }}</td>
                                        <td>{{ $plan->free_notes ? 'Yes' : 'No' }}</td>
                                        <td align="center">
                                            <div class="edit-1 d-flex align-items-center justify-content-center">
                                                <a class="edit-plan edit-icon"
                                                    href="{{ route('plans.edit', $plan->id) }}">
                                                    <span class="edit-icon"><i class="ph ph-pencil-simple"></i></span>
                                                </a>

                                                <a href="{{ route('plans.delete', $plan->id) }}"
                                                    onclick="return confirm('Are you sure to delete this plan?')">
                                                    <span class="trash-icon"><i class="ph ph-trash"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td colspan="8" class="text-center">No Data Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '#delete', function(e) {
            swal({
                    title: "Are you sure?",
                    text: "To delete this plans.",
                    type: "warning",
                    confirmButtonText: "Yes",
                    showCancelButton: true
                })
                .then((result) => {
                    if (result.value) {
                        window.location = $(this).data('route');
                    } else if (result.dismiss === 'cancel') {
                        swal(
                            'Cancelled',
                            'Your stay here :)',
                            'error'
                        )
                    }
                })
        });
    </script>
@endpush
