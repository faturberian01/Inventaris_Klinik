@extends('layouts.app')
@push('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendors/sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-7 col-lg-8 mx-auto">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form {{ $title }}</h6>

                    <button type="button" class="btn btn-success font-weight-bold"
                        onclick="document.getElementById('report-all').submit()">
                        Export All
                    </button>
                </div>
                <form action="{{ route('reports.index') }}" method="get">
                    <input type="hidden" name="preview" value="1" />
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-forms.label id="start_date">Start Date</x-forms.label>
                                    <x-forms.input type="date" name="start_date" :value="old('start_date', request('start_date'))" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-forms.label id="end_date">End Date</x-forms.label>
                                    <x-forms.input type="date" name="end_date" :value="old('end_date', request('end_date'))" />
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <x-forms.label id="type">Type</x-forms.label>
                            <x-forms.select name="type">
                                <option value="">All</option>
                                @foreach (\App\Enums\ProductType::getList() as $key => $label)
                                    <option value="{{ $key }}" @selected($key == old('type'))>{{ $label }}
                                    </option>
                                @endforeach
                            </x-forms.select>
                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary font-weight-bold">
                                Preview
                            </button>

                        </div>
                    </div>
                </form>
            </div>

            <form action="{{ route('reports.index') }}" method="post" target="_blank" id="report-all">
                @csrf
                <input type="hidden" name="all" value="1">
            </form>

            @if (request('preview'))
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Table Preview</h6>

                        <form action="{{ route('reports.index') }}" method="post" target="_blank">
                            @csrf

                            <input type="hidden" name="start_date"
                                value="{{ old('start_date', request('start_date')) }}" />

                            <input type="hidden" name="end_date" value="{{ old('end_date', request('end_date')) }}" />
                            <input type="hidden" name="type" value="{{ old('type', request('type')) }}" />

                            <button type="submit" class="btn btn-primary font-weight-bold">
                                Export to Excel
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Date</td>
                                        <td>Product Code</td>
                                        <td>Product Name</td>
                                        <td>Product Type</td>
                                        <td>Quantity</td>
                                        <td>Price</td>
                                        <td>Total Price</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($histories as $history)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $history->date->format('d F Y') }}</td>
                                            <td>{{ $history->product->code }}</td>
                                            <td>{{ $history->product->name }}</td>
                                            <td>{{ $history->product->type->getTranslated() }}</td>
                                            <td>{{ number_format($history->quantity) }}</td>
                                            <td>{{ \App\Helpers\BasicHelper::getRupiahFormat($history->product->price) }}
                                            </td>
                                            <td>{{ \App\Helpers\BasicHelper::getRupiahFormat($history->total) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendors/sb-admin-2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
