@extends('layouts.app')
@section('title')
    {{ $title ?? ucwords(str_replace('_', ' ', env('APP_NAME'))) }}
@endsection
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-block card-stretch card-height files-table">
                        <div class="card-header justify-content-between">
                            <div id="searchForm" class="text-right"></div>
                            <div class="dx-viewport">
                                <div class="demo-container">
                                    <div id="data-grid-demo">
                                        <div id="gridContainer" class="gridContainer"></div>
                                        <div id="formPopup"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const STUDENTS      = {!! $students !!};
    </script>
    <script src="{{ asset('page_assets/class/search.js') }}" type="module"></script>
@endsection
