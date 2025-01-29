@if (isset($edit))
<form action="{{ route('state.update') }}" method="POST" id="editForm" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" id="hidden_id" name="id" value="{{ $state->id ?? '' }}">
            <div class="row">
                {{-- country_id --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="country_id">Country<span class="text-danger">*</span></label>
                        <select class="form-control" id="country_id" name="edit_country_id">
                            <option value="">Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{$country->id}}"
                                    @if($country->id == $state->country_id) selected @endif>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- name --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="edit_name" id="edit_name" value="{{ $state->name ?? '' }}">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="submit-section">
        <button class="btn btn-primary submit-btn">Update</button>
    </div>
</form>

@endif
