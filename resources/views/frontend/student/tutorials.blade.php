@extends('frontend.layouts.student_app')

@section('content')
    <section class="dashboard">
        <div class="dashboard-contain">
            <div class="container">
                <h2 class="text-center my-4">{{ $page_title }}</h2>

                @if ($tutorials->isEmpty())
                    <div class="alert alert-warning text-center">No tutorials found.</div>
                @else
                    <div class="row">
                        @foreach ($tutorials as $tutorial)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card shadow-sm">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item"
                                            src="{{ Str::replace('watch?v=', 'embed/', $tutorial->url) }}"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ $tutorial->short_description }}</p>
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
        </div>
    </section>
@endsection
