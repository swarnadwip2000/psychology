@extends('admin.layouts.master')
@section('title')
    {{ env('APP_NAME') }} | Create Plan
@endsection
@push('styles')
@endpush
@section('head')
    Create Plan
@endsection

@section('content')
    <div class="main-content">
        <div class="inner_page">
            <div class="card search_bar sales-report-card">
                <div class="sales-report-card-wrap">
                    <div class="form-head">
                        <h4>Plan Information</h4>
                    </div>
                    <form action="{{ route('plans.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="plan_name">Plan Name*</label>
                                    <input type="text" class="form-control" id="plan_name" name="plan_name" value="{{ old('plan_name') }}" placeholder="Enter Plan Name">
                                    @if ($errors->has('plan_name'))
                                        <div class="error" style="color:red;">{{ $errors->first('plan_name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="plan_price">Plan Price*</label>
                                    <input type="text" class="form-control" id="plan_price" name="plan_price" value="{{ old('plan_price') }}" placeholder="Enter Plan Price">
                                    @if ($errors->has('plan_price'))
                                        <div class="error" style="color:red;">{{ $errors->first('plan_price') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="plan_duration_week">Plan Duration (Weeks)*</label>
                                    <input type="number" class="form-control" min="0" id="plan_duration_week" name="plan_duration_week" value="{{ old('plan_duration') }}" placeholder="Enter Duration in Days">
                                    @if ($errors->has('plan_duration_week'))
                                        <div class="error" style="color:red;">{{ $errors->first('plan_duration_week') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="session">Video Session*</label>
                                    <input type="number" class="form-control" min="0" id="session" name="session" value="{{ old('session') }}" placeholder="Enter Session">
                                    @if ($errors->has('session'))
                                        <div class="error" style="color:red;">{{ $errors->first('session') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="free_tutorial">Free Tutorial*</label>
                                    <select name="free_tutorial" id="free_tutorial" class="form-control">
                                        <option value="0" {{ old('free_tutorial') == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('free_tutorial') == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @if ($errors->has('free_tutorial'))
                                        <div class="error" style="color:red;">{{ $errors->first('free_tutorial') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="free_notes">Free Notes*</label>
                                    <select name="free_notes" id="free_notes" class="form-control">
                                        <option value="0" {{ old('free_notes') == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('free_notes') == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @if ($errors->has('free_notes'))
                                        <div class="error" style="color:red;">{{ $errors->first('free_notes') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="plan_description">Plan Description</label>
                                    <textarea class="form-control" id="plan_description" name="plan_description" placeholder="Enter Plan Description">{{ old('plan_description') }}</textarea>
                                    @if ($errors->has('plan_description'))
                                        <div class="error" style="color:red;">{{ $errors->first('plan_description') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Create Plan</button>
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
            // When the country is selected
            $('#country_id').change(function() {
                var countryId = $(this).val();  // Get the selected country id
                if (countryId) {
                    // Make an Ajax POST request to fetch cities based on country id
                    $.ajax({
                        url: "{{route('get.cities')}}", // The URL where the POST request will be sent
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',  // CSRF token for Laravel
                            country_id: countryId
                        },
                        success: function(data) {
                            // If cities are returned, populate the city dropdown
                            $('#city_id').empty();  // Clear previous options
                            $('#city_id').append('<option value="">Select State</option>');  // Default option
                            $.each(data, function(key, city) {
                                $('#city_id').append('<option value="' + city.id + '">' + city.name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log("Error: " + error);  // Handle error
                        }
                    });
                } else {
                    // If no country is selected, clear the city dropdown
                    $('#city_id').empty();
                    $('#city_id').append('<option value="">Select State</option>');
                }
            });
        });
    </script>
@endpush
