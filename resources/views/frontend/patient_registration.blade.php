@extends('frontend.layouts.frontend_app')
@section('content')
    <section class="boxArea" style="min-height: 580px; height: auto;">
        <div class="container">
            <h3 class="page-head text-center mb-5"> This form is strictly meant for those who intend to book special education session with the Counsellors.</h3>
            <h4 class="page-head text-center mb-5"> Enter your details</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <form action="{{ route('front.patient_registration_success') }}" method="POST"
                            onsubmit="return valid()">
                            <input type="hidden" name="register_as" value="3">
                            @csrf()
                            <div class="row">
                                <!-- Full Name -->
                                <div class="form-group col-md-6">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Full Name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email ID -->
                                <div class="form-group col-md-6">
                                    <label for="email_id">Email ID</label>
                                    <input type="text" class="form-control" id="email_id" name="email_id"
                                        placeholder="Email ID" value="{{ old('email_id') }}">
                                    @error('email_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group col-md-6">
                                    <label for="password">Please Choose A Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group col-md-6">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password"
                                        name="confirm_password" placeholder="Retype Password">
                                    @error('confirm_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Country Name -->
                                <div class="form-group col-md-6">
                                    <label for="country_name">Country Name</label>
                                    <select id="country_id" name="country_name" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($countries as $key => $val)
                                            <option value="{{ $val->id }}"
                                                {{ old('country_name') == $val->id ? 'selected' : '' }}>{{ $val->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- State -->
                                <div class="form-group col-md-6">
                                    <label for="city_name">State</label>
                                    <select id="city_id" name="city_name" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($city as $key => $val)
                                            <option value="{{ $val->id }}"
                                                {{ old('city_name') == $val->id ? 'selected' : '' }}>{{ $val->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Degree -->

                                {{-- problem_face --}}
                                <div class="form-group col-md-6">
                                    <label for="student_class">Class(If Studying)</label>
                                    <select id="student_class" name="student_class" class="form-control">
                                        <option value="">Select</option>
                                        @foreach (config('class.patient_class') as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                    @error('student_class')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            <div class="form-group col-md-6">
                                <label for="problem_face">Problems Being Faced</label>
                                <select id="problem_face" name="problem_face" class="form-control">
                                    <option value="">Select</option>
                                    @foreach (config('class.problem_faced') as $key => $val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                                @error('problem_face')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="student_age">Age</label>
                                <select id="student_age" name="student_age" class="form-control">
                                    <option value="">Select</option>
                                    @for ($i = 1; $i < 25; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    <option value="25+">25+</option>
                                </select>
                            </div>

                            {{-- //prefered_date_time --}}
                            <div class="form-group col-md-6">
                                <label for="prefered_date_time">Prefered Date and Time To Book Session With The Counsellor</label>
                                <input type="datetime-local" class="form-control" id="prefered_date_time"
                                    name="prefered_date_time" placeholder="Prefered Date and Time">
                                @error('prefered_date_time')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                    </div>
                    <div class="col-md-12 text-center ">
                        <span class="">You already have an account as a patient. <a href="{{ route('front.patient_login') }}">Click here</a> to log in.</span>

                        <br />
                        <br />
                        <input type="submit" class="btn btn-info w-50" value="Submit" />
                    </div>
                    </form>

                    <span class="text-center mb-5 mt-1">
                        Submitting the form will enable our counsellors to understand the issues being faced and get ready for the sessoion more efficiently.
                    </span>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // When the country is selected
            $('#country_id').change(function() {
                var countryId = $(this).val(); // Get the selected country id
                if (countryId) {
                    // Make an Ajax POST request to fetch cities based on country id
                    $.ajax({
                        url: "{{ route('get.cities') }}", // The URL where the POST request will be sent
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // CSRF token for Laravel
                            country_id: countryId
                        },
                        success: function(data) {
                            // If cities are returned, populate the city dropdown
                            $('#city_id').empty(); // Clear previous options
                            $('#city_id').append(
                            '<option value="">Select State</option>'); // Default option
                            $.each(data, function(key, city) {
                                $('#city_id').append('<option value="' + city.id +
                                    '">' + city.name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log("Error: " + error); // Handle error
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
@endsection
