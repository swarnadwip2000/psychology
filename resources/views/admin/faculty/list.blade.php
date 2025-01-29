@extends('admin.layouts.master')
@section('title')
    All Faculty Details - {{ env('APP_NAME') }}
@endsection
@push('styles')
    <style>
        .dataTables_filter {
            margin-bottom: 10px !important;
        }
    </style>
@endpush
@section('head')
    All Faculty Details
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
                            <div class="col-md-8 pr-0">
                                <div class="search-field prod-search">
                                    <input type="text" name="search" id="search" placeholder="search..." required
                                        class="form-control">
                                    <a href="javascript:void(0)" class="prod-search-icon"><i
                                            class="ph ph-magnifying-glass"></i></a>
                                </div>
                            </div>
                            {{-- <div class="col-md-3 pl-0 ml-2">
                                <button class="btn btn-primary button-search" id="search-button"> <span class=""><i
                                            class="ph ph-magnifying-glass"></i></span> Search</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="myTable" class="display">
                        <thead>
                            <tr>
                                <th class="sorting" data-tippy-content="Sort by Name" data-sorting_type="desc"
                                    data-column_name="name" style="cursor: pointer">
                                    Name <span id="name_icon"><i class="ph ph-caret-down"></i></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Email" data-sorting_type="desc"
                                    data-column_name="email" style="cursor: pointer">
                                    Email <span id="email_icon"></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Phone" data-sorting_type="desc"
                                    data-column_name="phone" style="cursor: pointer">
                                    Phone <span id="phone_icon"></span>
                                </th>
                                <th>
                                    State
                                </th>
                                <th>
                                    Country
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Address" data-sorting_type="desc"
                                    data-column_name="address" style="cursor: pointer">
                                    Address <span id="address_icon"></span>
                                </th>
                                {{--  <th class="sorting" data-tippy-content="Sort by Age" data-sorting_type="desc"
                                    data-column_name="student_age" style="cursor: pointer">
                                    Age <span id="age_icon"></span>
                                </th>  --}}
                                <th class="sorting" data-tippy-content="Sort by Degree" data-sorting_type="desc"
                                    data-column_name="dropdown_fuclaty_degree" style="cursor: pointer">
                                    Degree <span id="class_icon"></span>
                                </th>
                                {{--  <th>
                                    Institute Name
                                </th>  --}}
                                {{--  <th class="sorting" data-tippy-content="Sort by Register As" data-sorting_type="desc"
                                    data-column_name="register_as" style="cursor: pointer">
                                    Register As <span id="register_as_icon"></span>
                                </th>  --}}
                                <th>
                                    Status
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @include('admin.faculty.table')

                        </tbody>
                    </table>
                    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
                    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
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
                    text: "To delete this faculty.",
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
    <script>
        $('.toggle-class').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var user_id = $(this).data('id');

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('faculty.change-status') }}',
                data: {
                    'status': status,
                    'user_id': user_id
                },
                success: function(resp) {
                    console.log(resp.success)
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            // Function to clear sorting icons
            function clear_icon() {
                $('#name_icon').html('');
                $('#email_icon').html('');
                $('#phone_icon').html('');
                $('#city_icon').html('');
                $('#country_icon').html('');
                $('#address_icon').html('');
                $('#age_icon').html('');
                $('#class_icon').html('');
            }

            // Function to fetch data with AJAX
            function fetch_data(page, sort_type, sort_by, query) {
                $.ajax({
                    url: "{{ route('faculty.fetch-data') }}",
                    data: {
                        page: page,
                        sortby: sort_by,
                        sorttype: sort_type,
                        query: query
                    },
                    success: function(data) {
                        $('tbody').html(data.data); // Update the table body with new data
                    }
                });
            }

            // Search functionality (live search)
            $(document).on('keyup', '#search', function() {
                var query = $('#search').val();
                var column_name = $('#hidden_column_name').val();
                var sort_type = $('#hidden_sort_type').val();
                var page = $('#hidden_page').val();
                fetch_data(page, sort_type, column_name, query);
            });

            // Sorting functionality
            $(document).on('click', '.sorting', function() {
                var column_name = $(this).data('column_name');
                var order_type = $(this).data('sorting_type');
                var reverse_order = '';

                if (order_type == 'asc') {
                    $(this).data('sorting_type', 'desc');
                    reverse_order = 'desc';
                    clear_icon();
                    $('#' + column_name + '_icon').html('<i class="ph ph-caret-down"></i>');
                }
                if (order_type == 'desc') {
                    $(this).data('sorting_type', 'asc');
                    reverse_order = 'asc';
                    clear_icon();
                    $('#' + column_name + '_icon').html('<i class="ph ph-caret-up"></i>');
                }

                $('#hidden_column_name').val(column_name);
                $('#hidden_sort_type').val(reverse_order);
                var page = $('#hidden_page').val();
                var query = $('#search').val();
                fetch_data(page, reverse_order, column_name, query);
            });

            // Pagination functionality
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                $('#hidden_page').val(page);
                var column_name = $('#hidden_column_name').val();
                var sort_type = $('#hidden_sort_type').val();
                var query = $('#search').val();

                $('li').removeClass('active');
                $(this).parent().addClass('active');
                fetch_data(page, sort_type, column_name, query);
            });

        });
    </script>
@endpush
