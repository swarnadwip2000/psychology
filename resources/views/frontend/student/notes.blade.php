@extends('frontend.layouts.student_app')
<style>
    .resize {
        max-width: 300px;
    }
</style>
@section('content')
    <section class="dashboard">
        <div class="dashboard-contain">
            <div class="container">
                <h2 class="text-center my-4">{{ $page_title }}</h2>

                @if ($notes->isEmpty())
                    <div class="alert alert-warning text-center">No notes found.</div>
                @else
                    <div class="row">
                        @foreach ($notes as $note)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        @php
                                            $extension = pathinfo($note->file, PATHINFO_EXTENSION);
                                        @endphp

                                        @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                                            <!-- Show image preview with fixed size -->
                                            <img src="{{ asset($note->file) }}" class="file-preview resize rounded" alt="Note Image">
                                        @elseif(in_array($extension, ['pdf']))
                                            <!-- PDF Preview with fixed size -->
                                            <iframe src="{{ asset($note->file) }}" class="file-preview resize pdf-preview"></iframe>
                                        @elseif(in_array($extension, ['doc', 'docx']))
                                            <!-- Show Word Icon -->
                                            <img src="{{ asset('client_assets/img/file-icon.png') }}" class="file-icon resize" alt="Word Document">
                                        @else
                                            <!-- Default file icon -->
                                            <img src="{{ asset('client_assets/img/file-icon.png') }}" class="file-icon resize" alt="File">
                                        @endif

                                        <p class="mt-2">{{ $note->short_description }}</p>
                                        <a href="{{ asset($note->file) }}" class="btn btn-primary btn-sm resize" target="_blank">View File</a>
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
        </div>
    </section>
@endsection
