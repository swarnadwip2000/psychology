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
                                    <h4 class="card-title">Document</h4>
                                </div>

                                <div><span class="">
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#exampleModal">
                                            Add Document
                                        </button>
                                    </span></div>

                            </div>
                            <div class="card-body table-fixed p-0">
                                <div class="table-responsive">
                                    <table class="table mt-3">
                                        <thead>
                                            <tr>
                                                <th>Class</th>
                                                <th>URL</th>
                                                <th>File</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($documents->isEmpty())
                                                <tr>
                                                    <td colspan="4" class="text-center">No documents found.</td>
                                                </tr>
                                            @else
                                                @foreach ($documents as $document)
                                                    <tr>
                                                        <td> {{ config('class.all_class')[$document->class] ?? 'N/A' }}</td>
                                                        <td><a href="{{ asset($document->file) }}"
                                                                target="_blank">View</a></td>
                                                        <td>{{ $document->short_description }}</td>
                                                        <td>
                                                            {{-- <a href="{{ route('teacher.documents.edit', $document->id) }}"
                                                                class="btn btn-warning btn-sm">Edit</a> --}}
                                                            <form action="{{ route('teacher.documents.destroy', $document->id) }}"
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
                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $documents->links() }}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Add Document Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="tutorialForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="class">Class</label>
                            <select name="class" id="class" class="form-control">
                                <option value="">Select Class</option>
                                @foreach (config('class.all_class') as $key => $val)
                                    <option value="{{ $key }}" {{ old('class') == $key ? 'selected' : '' }}>
                                        {{ $val }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="url">File</label>
                            <input type="file" class="form-control" id="file" name="file">
                        </div>
                        <div class="form-group">
                            <label for="short_description">Short Description</label>
                            <textarea class="form-control" id="short_description" name="short_description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Document</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#tutorialForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Create FormData object
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('teacher.documents.store') }}', // Your route to store the document
                    method: 'POST',
                    data: formData,
                    processData: false, // Required for FormData
                    contentType: false, // Required for FormData
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            $('.error').remove(); // Remove previous errors

                            for (var field in errors) {
                                var errorMessage = errors[field].join(', ');
                                $('#' + field).closest('.form-group').append(
                                    '<div class="error text-danger">' + errorMessage +
                                    '</div>'
                                );
                            }
                        } else {
                            alert('An error occurred while adding the document.');
                        }
                    }
                });
            });
        });
    </script>
@endpush
