@extends('frontend.layouts.frontend_app')
@section('content')
    <section class="boxArea" style="min-height: 580px; height: auto;">
        <div class="container">
            <h4 class="page-head text-center mb-5"> Enter your details</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <form action="{{ route('front.faculty_registration_success') }}" method="POST"
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
                                    <select id="country_name" name="country_name" class="form-control">
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

                                <!-- City -->
                                <div class="form-group col-md-6">
                                    <label for="city_name">City</label>
                                    <select id="city_name" name="city_name" class="form-control">
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
                                <div class="form-group col-md-6">
                                    <label for="degree">Degree</label>
                                    <select id="degree" name="degree" class="form-control">
                                        <option value="">Select</option>
                                        @foreach (config('class.dropdown_fuclaty_degree') as $key => $val)
                                            <option value="{{ $val['id'] }}"
                                                {{ old('degree') == $val['id'] ? 'selected' : '' }}>{{ $val['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('degree')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 text-center">
                                <span>Login <a href="{{ route('front.faculty_login') }}">Click Here</a></span>
                                <br />
                                <input type="submit" class="btn btn-info" value="Submit" />
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
@endsection
