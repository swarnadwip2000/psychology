@extends('frontend.layouts.frontend_app')
@section('content')
    <section class="boxArea" style="min-height: 580px; height: auto;">
        <div class="container">
            <h4 class="page-head text-center mb-5"> Enter your details</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <form action="{{ route('front.registration_success') }}" method="POST" onsubmit="return valid()">
                            <input type="hidden" name="register_as" value="1">
                            @csrf()
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="student_age">Age</label>
                                    <select id="student_age" name="student_age" class="form-control">
                                        <option value="">Select</option>
                                        @for ($i = 20; $i < 45; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="student_class">Class</label>
                                    <select id="student_class" name="student_class" class="form-control">
                                        <option value="">Select</option>
                                        @foreach (config('class.school_class') as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="country_name">Country Name</label>
                                    <select id="country_name" name="country_name" class="form-control">
                                        <option selected>Select</option>
                                        <option value="">Select</option>
                                        @foreach ($countries as $key => $val)
                                            <option value="{{ $val->id }}"
                                                {{ old('country_name') == $val->id ? 'selected' : '' }}>{{ $val->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="city_name">City</label>
                                    <select id="city_name" name="city_name" class="form-control">
                                        <option selected>Select</option>
                                        @foreach ($city as $key => $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="school_name">School Name</label>
                                <input type="text" class="form-control" id="school_name" name="school_name"
                                    placeholder="School Name">
                            </div>
                            <div class="col-md-12 text-center">
                                <input type="submit" class="btn btn-info" value="Next" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        function valid() {
            if ($("#student_age").val() == '') {
                toastr.error('Enter your age!!');
                return false;
            } else if ($("#student_class").val() == '') {
                toastr.error('Enter your class!!');
                return false;
            } else if ($("#country_name").val() == '') {
                toastr.error('Enter your country name!!');
                return false;
            } else if ($("#city_name").val() == '') {
                toastr.error('Enter your city name!!');
                return false;
            } else if ($("#school_name").val() == '') {
                toastr.error('Enter your school name!!');
                return false;
            }


        }
    </script>
@endsection
