@if (isset($edit))
<form action="{{ route('country.update') }}" method="POST" id="editForm" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" id="hidden_id" name="id" value="{{ $country->id ?? '' }}">
            <div class="row">
                {{-- name --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="edit_name" id="edit_name" value="{{ $country->name ?? '' }}">
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
