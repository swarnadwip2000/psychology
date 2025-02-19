@extends('admin.layouts.master')
@section('title')
    Subscription Payment Details - {{ env('APP_NAME') }}
@endsection
@push('styles')
    <style>
        .dataTables_filter {
            margin-bottom: 10px !important;
        }
    </style>
@endpush
@section('head')
    Subscription Payment Details
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
                                <th class="sorting" data-tippy-content="Sort by Payment ID" data-sorting_type="desc"
                                    data-column_name="payment_id" style="cursor: pointer">
                                    Payment ID <span id="payment_id_icon"></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Name" data-sorting_type="desc"
                                    data-column_name="user_name" style="cursor: pointer">
                                    Name <span id="name_icon"><i class="ph ph-caret-down"></i></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Email" data-sorting_type="desc"
                                    data-column_name="user_email" style="cursor: pointer">
                                    Email <span id="email_icon"></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Plan" data-sorting_type="desc"
                                    data-column_name="plan_name" style="cursor: pointer">
                                    Plan <span id="plan_name_icon"></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Price" data-sorting_type="desc"
                                    data-column_name="plan_price" style="cursor: pointer">
                                    Price <span id="plan_price_icon"></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Duration" data-sorting_type="desc"
                                    data-column_name="plan_duration" style="cursor: pointer">
                                    Duration <span id="plan_duration_icon"></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Session" data-sorting_type="desc"
                                    data-column_name="session" style="cursor: pointer">
                                    Session <span id="session_icon"></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Free Tutorial" data-sorting_type="desc"
                                    data-column_name="free_tutorial" style="cursor: pointer">
                                    Free Tutorial <span id="free_tutorial_icon"></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Amount" data-sorting_type="desc"
                                    data-column_name="amount" style="cursor: pointer">
                                    Amount <span id="amount_icon"></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Expiry Date" data-sorting_type="desc"
                                    data-column_name="membership_start_date" style="cursor: pointer">
                                    Start Date <span id="membership_start_date_icon"></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Expiry Date" data-sorting_type="desc"
                                    data-column_name="membership_expiry_date" style="cursor: pointer">
                                    Expiry Date <span id="membership_expiry_date_icon"></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Currency" data-sorting_type="desc"
                                    data-column_name="currency" style="cursor: pointer">
                                    Currency <span id="currency_icon"></span>
                                </th>
                                <th class="sorting" data-tippy-content="Sort by Payment Method" data-sorting_type="desc"
                                    data-column_name="payment_method" style="cursor: pointer">
                                    Payment Method <span id="payment_method_icon"></span>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @include('admin.payment.table')
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
        $(document).ready(function() {

            // Function to clear sorting icons
            function clear_icon() {
                $('#payment_id_icon').html('');
                $('#name_icon').html('');
                $('#email_icon').html('');
                $('#plan_name_icon').html('');
                $('#plan_price_icon').html('');
                $('#plan_duration_icon').html('');
                $('#session_icon').html('');
                $('#free_tutorial_icon').html('');
                $('#amount_icon').html('');
                $('#membership_expiry_date_icon').html('');
                $('#membership_start_date_icon').html('');
                $('#currency_icon').html('');
                $('#payment_method_icon').html('');
            }


            // Function to fetch data with AJAX
            function fetch_data(page, sort_type, sort_by, query) {
                $.ajax({
                    url: "{{ route('admin.payment-fetch-data') }}",
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
