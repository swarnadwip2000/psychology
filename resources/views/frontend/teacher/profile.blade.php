@extends('frontend.layouts.teacher_app')
@section('content')
    <section class="dshboard" style="height: 100%">
        <div class="dshboard-contain">
            <div class="container">
                <form action="{{ route('teacher.update_profile') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-lg-12 col-md-12">
                            <div class="d-block d-md-flex align-items-center">
                                <div class="left_img me-3 profile_img">
                                    <span>
                                        @if (Auth::user()->profile_picture)
                                            <img src="{{ asset(Auth::user()->profile_picture) }}" alt=""
                                                id="blah">
                                        @else
                                            <img src="{{ asset('client_assets/img/images.png') }}" alt=""
                                                id="blah" />
                                        @endif
                                    </span>
                                    <div class="profile_eidd">
                                        <input type="file" id="edit_profile" onchange="readURL(this);"
                                            name="profile_picture" />
                                        <label for="edit_profile"><i class="fas fa-pencil"></i></label>
                                    </div>
                                    @if ($errors->has('profile_picture'))
                                        <div class="error" style="color:red;">{{ $errors->first('profile_picture') }}</div>
                                    @endif
                                </div>
                                <div class="right_text profile-info ml-2">
                                    <p>Hello!</p>
                                    <h2> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h2>
                                    <p>{{ Auth::user()->email }}</p>
                                    <span>

                                        <b>
                                            {{ Auth::user()->ecclesia ? 'Ecclesia: ' . Auth::user()->ecclesia->name : '' }}
                                        </b>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-between mt-5 mb-5">
                        <div class="col-xl-4 col-md-6">
                            <div class="form-group-div">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ Auth::user()->name }}" placeholder="Full Name">
                                    @if ($errors->has('name'))
                                        <div class="error" style="color:red;">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6">
                            <div class="form-group-div">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ Auth::user()->phone }}" placeholder="Phone Number">
                                    @if ($errors->has('phone'))
                                        <div class="error" style="color:red;">{{ $errors->first('phone') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6">
                            <div class="form-group-div">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ Auth::user()->address }}" placeholder="Address">
                                    @if ($errors->has('address'))
                                        <div class="error" style="color:red;">{{ $errors->first('address') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="form-group-div">
                                <div class="form-group">
                                    <label for="country_id">Country</label>
                                    <select id="country_id" name="country_id" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $key => $country)
                                            <option value="{{ $country->id }}" {{ old('country_id', Auth::user()->country_id) == $country->id ? 'selected' : '' }}>
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
                        <div class="col-xl-4 col-md-6">
                            <div class="form-group-div">
                                <div class="form-group">
                                    <label for="city_id">State</label>
                                    <select id="city_id" name="city_id" class="form-control">
                                        <option value="">Select State</option>
                                        {{--  @foreach ($cities as $key => $val)
                                            <option value="{{ $val->id }}" {{ old('city_id', Auth::user()->city_id) == $val->id ? 'selected' : '' }}>
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



                        <div class="col-xl-4 col-md-6">
                            <div class="form-group-div">
                                <div class="form-group">
                                    <label for="degree">Degree</label>
                                    <select name="degree" id="degree" class="form-control">
                                        <option value="">Select Degree</option>
                                        @foreach (config('class.fuclaty_degree') as $key => $val)
                                            <option value="{{ $key }}" {{ old('degree', Auth::user()->degree) == $key ? 'selected' : '' }}>
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

                        <div class="col-xl-12">
                            <div class="form-group-div">
                                <div class="form-group">
                                    <label for="bio">Bio</label>
                                    <textarea class="form-control" id="bio" name="bio" placeholder="Write something about yourself">{{ Auth::user()->bio }}</textarea>
                                    @if ($errors->has('bio'))
                                        <div class="error" style="color:red;">{{ $errors->first('bio') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6">
                            <div class="btn-1">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection
@section('script')

<script>
    $(document).ready(function() {
        // This is to load cities for the selected country when editing
        var selectedCountryId = '{{ Auth::user()->country_id ?? '' }}'; // Laravel variable passed to view
        var selectedCityId = '{{ Auth::user()->city_id ?? '' }}'; // Laravel variable passed to view

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
                $('#city_id').append('<option value="">Select State</option>');
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
                    $('#city_id').append('<option value="">Select State</option>');
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
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
