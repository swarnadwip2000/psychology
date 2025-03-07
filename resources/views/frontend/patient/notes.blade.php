@extends('frontend.layouts.student_app')

@section('content')
    <section class="dashboard py-5">
        <div class="container">
            <h2 class="text-center mb-4">{{ $page_title }}</h2>

            @if ($notes->isEmpty())
                <div class="alert alert-warning text-center">No notes found.</div>
            @else
                <div class="row">
                    @foreach ($notes as $note)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body text-center d-flex flex-column">
                                    @php
                                        $extension = pathinfo($note->file, PATHINFO_EXTENSION);
                                    @endphp

                                    @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                                        <img src="{{ asset($note->file) }}" class="file-preview rounded img-fluid" alt="Note Image">
                                    @elseif(in_array($extension, ['pdf']))
                                        <iframe src="{{ asset($note->file) }}" class="file-preview pdf-preview border rounded" style="width: 100%; height: 200px;"></iframe>
                                    @elseif(in_array($extension, ['doc', 'docx']))
                                        <img src="{{ asset('client_assets/img/file-icon.png') }}" class="file-previewfile-icon img-fluid" alt="Word Document">
                                    @else
                                        <img src="{{ asset('client_assets/img/file-icon.png') }}" class="file-previewfile-icon img-fluid" alt="File">
                                    @endif

                                    <h6 class="mt-3">{{ Str::limit($note->short_description, 80) }}</h6>
                                    <small class="text-secondary">Added by {{ $note->teacher->name ?? 'Unknown' }}</small>

                                    <a href="{{ asset($note->file) }}" class="btn btn-primary btn-sm mt-3" target="_blank">
                                        View File
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $notes->links() }}
            </div>
        </div>
    </section>

    <style>
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            border-radius: 10px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .file-preview {
            max-height: 200px;
            object-fit: cover;
        }
    </style>
@endsection
