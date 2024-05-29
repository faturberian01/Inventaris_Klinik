@extends('layouts.app')

@push('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendors/sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('products.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50 mr-2"></i> Add Product</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Table {{ $title }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Photo</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->code }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ str($product->description)->words(8) }}</td>
                                        <td>{{ \App\Helpers\BasicHelper::getRupiahFormat($product->price) }}</td>
                                        <td>{{ $product->type->getTranslated() }}</td>
                                        <td><img src="{{ $product->getPhoto() }}" alt="Product Photo" width="50" />
                                        </td>

                                        <td>
                                            <a href="{{ route('products.edit', $product) }}"
                                                class="badge bg-primary text-white">edit</a>
                                            <a href="{{ route('products.detail', $product) }}"
                                                class="badge bg-success text-white">detail</a>
                                            <form action="{{ route('products.destroy', $product) }}"
                                                onsubmit="return confirm('Are you sure to delete this product?')"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="border-0 badge bg-danger text-white">delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
