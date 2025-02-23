@extends('frontend.layouts.student_app')

@section('content')
    <section class="dashboard py-5">
        <div class="container">
            <h2 class="text-center mb-4">{{ $page_title }}</h2>

            <!-- Show error message if redirected -->
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Bootstrap Nav Tabs -->
            <ul class="nav nav-tabs mb-4" id="resourceTabs" role="tablist">
                @if($hasTutorialAccess)
                    <li class="nav-item">
                        <a class="nav-link active" id="tutorials-tab" data-bs-toggle="tab" href="#tutorials" role="tab">Tutorials</a>
                    </li>
                @endif

                @if($hasNotesAccess)
                    <li class="nav-item">
                        <a class="nav-link {{ !$hasTutorialAccess ? 'active' : '' }}" id="notes-tab" data-bs-toggle="tab" href="#notes" role="tab">Notes</a>
                    </li>
                @endif
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="resourceTabsContent">
                <!-- Tutorials Tab -->
                @if($hasTutorialAccess)
                    <div class="tab-pane fade show active" id="tutorials" role="tabpanel">
                        @if ($tutorials->isEmpty())
                            <div class="alert alert-warning text-center">No tutorials found.</div>
                        @else
                            <div class="row">
                                @foreach ($tutorials as $tutorial)
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="card fixed-card shadow-sm border-0 h-100">
                                            <div class="ratio ratio-16x9">
                                                <iframe class="rounded-top border-0"
                                                    src="{{ Str::replace('watch?v=', 'embed/', $tutorial->url) }}"
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title">{{ Str::limit($tutorial->title, 50) }}</h5>
                                                <p class="card-text text-muted">{{ Str::limit($tutorial->short_description, 100) }}</p>
                                                <small class="text-secondary mt-auto">Added by {{ $tutorial->teacher->name ?? 'Unknown' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Notes Tab -->
                @if($hasNotesAccess)
                    <div class="tab-pane fade {{ !$hasTutorialAccess ? 'show active' : '' }}" id="notes" role="tabpanel">
                        @if ($notes->isEmpty())
                            <div class="alert alert-warning text-center">No notes found.</div>
                        @else
                            <div class="row">
                                @foreach ($notes as $note)
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="card fixed-card shadow-sm border-0 h-100">
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
                    </div>
                @endif
            </div>
        </div>
    </section>

    <style>
        .fixed-card {
            height: 350px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .fixed-card .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

    </style>
    
@endsection
