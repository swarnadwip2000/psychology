@extends('frontend.layouts.teacher_app')
@section('title')
    {{ ucwords(str_replace('_', ' ', env('APP_NAME'))) }}
@endsection
@section('content')
    <section class="dshboard p-3 mb-5" style="height: ">
        <div class="dshboard-contain">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Tutorial</h4>
                                </div>

                                <div><span class="">
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#exampleModal">
                                            Add Tutorial
                                        </button>
                                    </span></div>

                            </div>
                            <div class="card-body table-fixed p-0">
                                <div class="table-responsive">
                                    <table class="table mt-3">
                                        <thead>
                                            <tr>
                                                <th>Degree</th>
                                                <th>URL</th>
                                                <th>Short Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($tutorials->isEmpty())
                                                <tr>
                                                    <td colspan="4" class="text-center">No tutorials found.</td>
                                                </tr>
                                            @else
                                                @foreach ($tutorials as $tutorial)
                                                    <tr>
                                                        <td> {{ config('class.fuclaty_degree')[$tutorial->degree] ?? 'N/A' }}</td>
                                                        <td><a href="{{ $tutorial->url }}" target="_blank">View</a></td>
                                                        <td>{{ $tutorial->short_description }}</td>
                                                        <td>
                                                            {{-- <a href="{{ route('teacher.tutorials.edit', $tutorial->id) }}"
                                                                class="btn btn-warning btn-sm">Edit</a> --}}
                                                            <form action="{{ route('teacher.tutorials.destroy', $tutorial->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Add Tutorial Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Tutorial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="tutorialForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="degree">Degree</label>
                            <select name="degree" id="degree" class="form-control">
                                <option value="">Select Degree</option>
                                @foreach (config('class.fuclaty_degree') as $key => $val)
                                    <option value="{{ $key }}" {{ old('degree') == $key ? 'selected' : '' }}>
                                        {{ $val }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="url">URL</label>
                            <input type="url" class="form-control" id="url" name="url">
                        </div>
                        <div class="form-group">
                            <label for="short_description">Short Description</label>
                            <textarea class="form-control" id="short_description" name="short_description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Tutorial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // When the form is submitted
            $('#tutorialForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Get form data
                var formData = $(this).serialize();

                // Send AJAX request
                $.ajax({
                    url: '{{ route('teacher.tutorials.store') }}', // Your route to store tutorial
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Check for validation errors
                        var errors = xhr.responseJSON.errors;

                        if (errors) {
                            // Clear any previous error messages
                            $('.error').remove();

                            // Loop through each error and display it
                            for (var field in errors) {
                                var errorMessages = errors[field];
                                var errorMessage = errorMessages.join(
                                ', '); // Combine all error messages for this field

                                // Find the form field and append error message
                                var errorElement = $('#' + field).closest('.form-group').append(
                                    '<div class="error text-danger">' + errorMessage +
                                    '</div>'
                                );
                            }
                        } else {
                            alert('An error occurred while adding the tutorial.');
                        }
                    }
                });
            });
        });
    </script>
@endpush
