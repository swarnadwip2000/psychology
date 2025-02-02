@extends('admin.layouts.master')
@section('title')
    State - {{ env('APP_NAME') }}
@endsection
@push('styles')
    <style>
        .dataTables_filter {
            margin-bottom: 10px !important;
        }

        .eye-btn-1 {
            top: 39px;
            right: 24px;
        }
    </style>
@endpush
@section('head')
    State
@endsection
@section('create_button')
    <a href="javascript:void(0)" id="create-state" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_admin">Add
        State</a>
@endsection

@section('content')
    <section id="loading">
        <div id="loading-content"></div>
    </section>
    <div id="add_admin" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">State Information</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('state.store') }}" method="POST" id="createForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    {{-- user_name --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Country<span class="text-danger">*</span></label>
                                            <select class="select2 form-control" name="country_id" id="country_id">
                                                <option value="">Select Country</option>
                                                @foreach ($states as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="edit_state" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">State Information</h5>
                    <button type="button" class="edit_close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="edit-state">
                    @include('admin.state.edit')

                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="inner_page">

            <div class="card table_sec stuff-list-table">
                <div class="row justify-content-end">
                    <div class="col-md-6">
                        <div class="row g-1 justify-content-end">

                            {{-- <div class="col-md-3 pl-0 ml-2">
                                <button class="btn btn-primary button-search" id="search-button"> <span class=""><i
                                            class="ph ph-magnifying-glass"></i></span> Search</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="table-responsive" id="contacts-data">
                    <table id="example" class="dd table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>
                                    State Name
                                </th>
                                <th>
                                    Country
                                </th>
                                <th>
                                    Created Date
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($states) > 0)
                                @foreach ($states as $key => $state)
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>{{ $state->name }}</td>
                                        <td>{{ $state->country->name }}</td>
                                        <td>{{ date('d M Y', strtotime($state->created_at)) }}</td>
                                        <td align="center">
                                            <div class="edit-1 d-flex align-items-center justify-content-center">

                                                <a class="edit-states edit-icon" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#edit_state" data-id="{{ $state->id }}"
                                                    data-route="{{ route('state.edit', $state->id) }}"> <span
                                                        class="edit-icon"><i class="ph ph-pencil-simple"></i></span></a>


                                                <a href="{{ route('state.delete', $state->id) }}"
                                                    onclick="return confirm('Are you sure to delete this state?')"> <span
                                                        class="trash-icon"><i class="ph ph-trash"></i></span></a>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                                @if ($states->hasPages())
                                    <tr>
                                        <td colspan="4">
                                            <div class="d-flex justify-content-center">
                                                {!! $states->links() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No Data Found</td>
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
    {{-- create-state --}}
    <script>
        $(document).ready(function() {
            $('#create-state').on('click', function() {
                $('#add_admin').modal('show');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#createForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var type = form.attr('method');
                var data = new FormData(form[0]);
                $('#loading').addClass('loading');
                $('#loading-content').addClass('loading-content');
                $.ajax({
                    url: url,
                    type: type,
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#loading').removeClass('loading');
                            $('#loading-content').removeClass('loading-content');
                            $('#add_admin').modal('hide');
                            location.reload();

                        } else {
                            $('#loading').removeClass('loading');
                            $('#loading-content').removeClass('loading-content');
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {
                        // validation error
                        if (data.status == 422) {
                            var errors = data.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                            $('#loading').removeClass('loading');
                            $('#loading-content').removeClass('loading-content');
                        }
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('submit', '#editForm', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var type = form.attr('method');
                var data = new FormData(form[0]);
                $('#loading').addClass('loading');
                $('#loading-content').addClass('loading-content');
                $.ajax({
                    url: url,
                    type: type,
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#loading').removeClass('loading');
                            $('#loading-content').removeClass('loading-content');
                            $('#edit_state').modal('hide');
                            location.reload();
                        } else {
                            $('#loading').removeClass('loading');
                            $('#loading-content').removeClass('loading-content');
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {
                        // validation error
                        if (data.status == 422) {
                            var errors = data.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                            $('#loading').removeClass('loading');
                            $('#loading-content').removeClass('loading-content');
                        }
                    }
                });
            });
        });
    </script>
    {{-- close --}}
    <script>
        $(document).ready(function() {
            $('.edit_close').on('click', function() {
                $('#edit_state').modal('hide');
            });

            $('.close').on('click', function() {
                $('#add_admin').modal('hide');
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $('.edit-states').on('click', function() {
                var id = $(this).data('id');
                var route = $(this).data('route');
                var img_url = $('#img-' + id).data('url');
                $('#loading').addClass('loading');
                $('#loading-content').addClass('loading-content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        id: id,
                    },
                    dataType: 'JSON',
                    success: async function(data) {
                        try {
                            await $('#edit_state').modal('show');
                            await $('#edit-state').html(data.data);
                            await $('#loading').removeClass('loading');
                            await $('#loading-content').removeClass('loading-content');
                        } catch (error) {
                            console.log(error);
                        }
                    }
                });
            });
        });
    </script>
@endpush
