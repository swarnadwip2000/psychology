@extends('admin.layouts.master')
@section('title')
    {{ env('APP_NAME') }} | Edit Faculty Details
@endsection
@push('styles')
@endpush
@section('head')
    Edit Faculty Details
@endsection
@section('content')
    <div class="main-content">
        <div class="inner_page">
            <div class="card search_bar sales-report-card">
                <div class="sales-report-card-wrap">
                    <div class="form-head">
                        <h4>Login Information</h4>
                    </div>
                    <form action="{{ route('faculty.update', $faculty->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <div class="form-group-div">
                                    <div class="form-group">
                                        <label for="floatingInputValue">Email Address*</label>
                                        <input type="text" class="form-control" id="floatingInputValue" name="email"
                                            value="{{ old('email', $faculty->email) }}" placeholder="Email Address*">
                                        @if ($errors->has('email'))
                                            <div class="error" style="color:red;">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-div">
                                    <div class="form-group">
                                        <label for="floatingInputValue">Mobile*</label>
                                        <input type="text" class="form-control" id="floatingInputValue" name="phone"
                                            value="{{ old('phone', $faculty->phone) }}" placeholder="Mobile*">
                                        @if ($errors->has('phone'))
                                            <div class="error" style="color:red;">{{ $errors->first('phone') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-div">
                                    <div class="form-group">
                                        <label for="floatingInputValue">Password*</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            value="{{ old('password') }}" placeholder="Password*">
                                        <span class="eye-btn-1" id="eye-button-1">
                                            <i class="ph ph-eye-slash" aria-hidden="true" id="togglePassword"></i>
                                        </span>
                                        @if ($errors->has('password'))
                                            <div class="error" style="color:red;">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-div">
                                    <div class="form-group">
                                        <label for="floatingInputValue">Confirm Password*</label>
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="confirm_password" value="{{ old('confirm_password') }}"
                                            placeholder="Confirm Password*">
                                        <span class="eye-btn-1" id="eye-button-2">
                                            <i class="ph ph-eye-slash" aria-hidden="true" id="togglePassword"></i>
                                        </span>
                                        @if ($errors->has('confirm_password'))
                                            <div class="error" style="color:red;">{{ $errors->first('confirm_password') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sales-report-card-wrap mt-5">
                            <div class="form-head">
                                <h4>Personal Information</h4>
                            </div>

                            <div class="row">
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group-div">
                                        <div class="form-group">
                                            <label for="floatingInputValue">Full Name*</label>
                                            <input type="text" class="form-control" id="floatingInputValue"
                                                name="name" value="{{ old('name', $faculty->name) }}" placeholder="Full Name*">
                                            @if ($errors->has('name'))
                                                <div class="error" style="color:red;">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- country_id --}}
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group-div">
                                        <div class="form-group">
                                            <label for="floatingInputValue">Country*</label>
                                            <select id="country_id" name="country_id" class="form-control">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $key => $country)
                                                    <option value="{{ $country->id }}" {{ old('country_id', $faculty->country_id) == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('country_id'))
                                                <div class="error" style="color:red;">{{ $errors->first('country_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Other fields --}}
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group-div">
                                        <div class="form-group">
                                            <label for="floatingInputValue">City*</label>
                                            <select id="city_id" name="city_id" class="form-control">
                                                <option value="">Select City</option>
                                                {{--  @foreach ($cities as $key => $val)
                                                    <option value="{{ $val->id }}" {{ old('city_id', $faculty->city_id) == $val->id ? 'selected' : '' }}>
                                                        {{ $val->name }}
                                                    </option>
                                                @endforeach  --}}
                                            </select>
                                            @if ($errors->has('city_id'))
                                                <div class="error" style="color:red;">{{ $errors->first('city_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                        <div class="form-group-div">
                            <div class="form-group">
                                <label for="floatingInputValue">Address*</label>
                                <input type="text" class="form-control" id="floatingInputValue"
                                    name="address" value="{{ old('address', $faculty->address) }}" placeholder="Address*">
                                @if ($errors->has('address'))
                                    <div class="error" style="color:red;">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{--  <div class="col-md-6">
                        <div class="form-group-div">
                            <div class="form-group">
                                <label for="floatingInputValue">School Name*</label>
                                <input type="text" class="form-control" id="floatingInputValue"
                                    name="institute_name" value="{{ old('institute_name', $student->institute_name) }}"
                                    placeholder="School Name*">
                                @if ($errors->has('institute_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('institute_name') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>  --}}
                    {{--  <div class="col-xl-6 col-md-6">
                        <div class="form-group-div">
                            <div class="form-group">
                                <label for="floatingInputValue">Age*</label>
                                <select name="student_age" id="student_age" class="form-control">
                                    <option value="">Select</option>
                                    @for ($i = 20; $i < 45; $i++)
                                        <option value="{{ $i }}" {{ old('student_age', $student->student_age) == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @if ($errors->has('student_age'))
                                    <div class="error" style="color:red;">{{ $errors->first('student_age') }}</div>
                                @endif
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group-div">
                            <div class="form-group">
                                <label for="floatingInputValue">Degree*</label>
                                <select name="degree" id="degree" class="form-control">
                                    <option value="">Select Degree</option>
                                    @foreach (config('class.fuclaty_degree') as $key => $val)
                                        <option value="{{ $key }}" {{ old('degree', $faculty->degree) == $key ? 'selected' : '' }}>
                                            {{ $val }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('degree'))
                                    <div class="error" style="color:red;">{{ $errors->first('degree') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{--  <div class="col-xl-6 col-md-6">
                        <div class="form-group-div">
                            <div class="form-group">
                                <label for="floatingInputValue">Register As*</label>
                                <select name="register_as" id="register_as" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="1" {{ old('register_as', $faculty->register_as) == 1 ? 'selected' : '' }}>School</option>
                                    <option value="2" {{ old('register_as', $faculty->register_as) == 2 ? 'selected' : '' }}>Collage</option>
                                    <option value="3" {{ old('register_as', $faculty->register_as) == 3 ? 'selected' : '' }}>Faculty</option>
                                </select>
                                @if ($errors->has('register_as'))
                                    <div class="error" style="color:red;">{{ $errors->first('register_as') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>  --}}
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group-div">
                            <div class="form-group">
                                <label for="floatingInputValue">Status*</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="1" {{ old('status', $faculty->status) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status', $faculty->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @if ($errors->has('status'))
                                    <div class="error" style="color:red;">{{ $errors->first('status') }}</div>
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
                    var countryId = $(this).val();  // Get the selected country id
                    if (countryId) {
                        loadCities(countryId); // Load cities when a country is selected
                    } else {
                        $('#city_id').empty();
                        $('#city_id').append('<option value="">Select City</option>');
                    }
                });

                // Function to load cities
                function loadCities(countryId, selectedCityId = null) {
                    $.ajax({
                        url: "{{route('get.cities')}}", // Your AJAX route
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',  // CSRF token
                            country_id: countryId
                        },
                        success: function(data) {
                            $('#city_id').empty();
                            $('#city_id').append('<option value="">Select City</option>');
                            $.each(data, function(key, city) {
                                var selected = (selectedCityId && selectedCityId == city.id) ? 'selected' : '';
                                $('#city_id').append('<option value="' + city.id + '" ' + selected + '>' + city.name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log("Error: " + error);  // Handle errors
                        }
                    });
                }
            });
    </script>
@endpush
