@extends('layouts.base')

@push('style')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('base')

<div class="pre-loader d-flex align-items-center justify-content-center">
    <div>
        <img src="{{ asset('images/spinner.gif') }}" alt="Loading...." width="400">
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <main class="mx-auto col-lg-10 px-md-4">
            <div class="container">
                <div class="row">
                    <div
                        class="col d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                        <h1 class="h2">
                            <span class="text-muted h2 fw-bold">#</span>
                            {{ $title }}
                        </h1>
                        {{-- <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                                <span data-feather="calendar" class="align-text-middle"></span>
                                This week
                            </button>
                        </div> --}}
                        @yield('buttons')
                    </div>
                </div>
            </div>

            <div class="py-4">
                <div class="container-lg">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('js/preloader.js') }}"></script>
@endpush