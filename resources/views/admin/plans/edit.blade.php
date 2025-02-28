@extends('admin.layouts.master')
@section('title')
    {{ env('APP_NAME') }} | Edit Plan Details
@endsection
@push('styles')
@endpush
@section('head')
    Edit Plan Details
@endsection
@section('content')
    <div class="main-content">
        <div class="inner_page">
            <div class="card search_bar sales-report-card">
                <div class="sales-report-card-wrap">

                    <form action="{{ route('plans.update', $plan->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <!-- Existing form fields -->

                        <div class="sales-report-card-wrap mt-5">
                            <div class="form-head">
                                <h4>Plan Information</h4>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-div">
                                        <div class="form-group">
                                            <label for="plan_name">Plan Name*</label>
                                            <input type="text" class="form-control" id="plan_name" name="plan_name"
                                                value="{{ old('plan_name', $plan->plan_name) }}" placeholder="Plan Name">
                                            @if ($errors->has('plan_name'))
                                                <div class="error" style="color:red;">{{ $errors->first('plan_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group-div">
                                        <div class="form-group">
                                            <label for="plan_price">Plan Price*</label>
                                            <input type="text" class="form-control" id="plan_price" name="plan_price"
                                                value="{{ old('plan_price', $plan->plan_price) }}" placeholder="Plan Price">
                                            @if ($errors->has('plan_price'))
                                                <div class="error" style="color:red;">{{ $errors->first('plan_price') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group-div">
                                        <div class="form-group">
                                            <label for="plan_duration_week">Plan Duration (in weeks)*</label>
                                            <input type="number" class="form-control" min="0" id="plan_duration_week" name="plan_duration_week"
                                                value="{{ old('plan_duration_week', $plan->plan_duration_week) }}" placeholder="Plan Duration">
                                            @if ($errors->has('plan_duration_week'))
                                                <div class="error" style="color:red;">{{ $errors->first('plan_duration_week') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group-div">
                                        <div class="form-group">
                                            <label for="session">Video Session*</label>
                                            <input type="number" class="form-control" min="0" id="session" name="session"
                                                value="{{ old('session', $plan->session) }}" placeholder="Session">
                                            @if ($errors->has('session'))
                                                <div class="error" style="color:red;">{{ $errors->first('session') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group-div">
                                        <div class="form-group">
                                            <label for="free_tutorial">Free Tutorial*</label>
                                            <select class="form-control" id="free_tutorial" name="free_tutorial">
                                                <option value="0" {{ old('free_tutorial', $plan->free_tutorial) == 0 ? 'selected' : '' }}>No</option>
                                                <option value="1" {{ old('free_tutorial', $plan->free_tutorial) == 1 ? 'selected' : '' }}>Yes</option>
                                            </select>
                                            @if ($errors->has('free_tutorial'))
                                                <div class="error" style="color:red;">{{ $errors->first('free_tutorial') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-div">
                                        <div class="form-group">
                                            <label for="free_notes">Free Notes*</label>
                                            <select class="form-control" id="free_notes" name="free_notes">
                                                <option value="0" {{ old('free_notes', $plan->free_tutorial) == 0 ? 'selected' : '' }}>No</option>
                                                <option value="1" {{ old('free_notes', $plan->free_tutorial) == 1 ? 'selected' : '' }}>Yes</option>
                                            </select>
                                            @if ($errors->has('free_notes'))
                                                <div class="error" style="color:red;">{{ $errors->first('free_notes') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group-div">
                                        <div class="form-group">
                                            <label for="free_documents">Free Documents*</label>
                                            <select class="form-control" id="free_documents" name="free_documents">
                                                <option value="0" {{ old('free_documents', $plan->free_tutorial) == 0 ? 'selected' : '' }}>No</option>
                                                <option value="1" {{ old('free_documents', $plan->free_tutorial) == 1 ? 'selected' : '' }}>Yes</option>
                                            </select>
                                            @if ($errors->has('free_documents'))
                                                <div class="error" style="color:red;">{{ $errors->first('free_documents') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group-div">
                                        <div class="form-group">
                                            <label for="plan_description">Plan Description</label>
                                            <textarea class="form-control" id="plan_description" name="plan_description" rows="4"
                                                placeholder="Enter Plan Description">{{ old('plan_description', $plan->plan_description) }}</textarea>
                                            @if ($errors->has('plan_description'))
                                                <div class="error" style="color:red;">{{ $errors->first('plan_description') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="btn-1">
                                <button type="submit">Update</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#eye-button-1').click(function() {
                $('#password').attr('type', $('#password').is(':password') ? 'text' : 'password');
                $(this).find('i').toggleClass('ph-eye-slash ph-eye');
            });
            $('#eye-button-2').click(function() {
                $('#confirm_password').attr('type', $('#confirm_password').is(':password') ? 'text' :
                    'password');
                $(this).find('i').toggleClass('ph-eye-slash ph-eye');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // This is to load cities for the selected country when editing
            var selectedCountryId = '{{ $selectedCountryId ?? '' }}'; // Laravel variable passed to view
            var selectedCityId = '{{ $selectedCityId ?? '' }}'; // Laravel variable passed to view

            if (selectedCountryId) {
                loadCities(selectedCountryId, selectedCityId); // Load cities based on the selected country
            }

            // When the country is selected
            $('#country_id').change(function() {
                var countryId = $(this).val(); // Get the selected country id
                if (countryId) {
                    loadCities(countryId); // Load cities when a country is selected
                } else {
                    $('#city_id').empty();
                    $('#city_id').append('<option value="">Select State</option>');
                }
            });

            // Function to load cities
            function loadCities(countryId, selectedCityId = null) {
                $.ajax({
                    url: "{{ route('get.cities') }}", // Your AJAX route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token
                        country_id: countryId
                    },
                    success: function(data) {
                        $('#city_id').empty();
                        $('#city_id').append('<option value="">Select State</option>');
                        $.each(data, function(key, city) {
                            var selected = (selectedCityId && selectedCityId == city.id) ?
                                'selected' : '';
                            $('#city_id').append('<option value="' + city.id + '" ' + selected +
                                '>' + city.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + error); // Handle errors
                    }
                });
            }
        });
    </script>
@endpush
