@extends('frontend.layouts.student_app')

@section('content')
    <section class="dashboard py-5">
        <div class="container">
            <h2 class="text-center mb-4">{{ $page_title }}</h2>

            @if ($tutorials->isEmpty())
                <div class="alert alert-warning text-center">No tutorials found.</div>
            @else
                <div class="row">
                    @foreach ($tutorials as $tutorial)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm border-0 h-100">
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

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $tutorials->links() }}
            </div>
        </div>
    </section>

    <style>
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            display: flex;
            flex-direction: column;
        }
    </style>
@endsection
