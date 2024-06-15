@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="{{ $product->getPhoto() }}" alt="Product Photo" class="img-thumbnail w-100 d-block" />
                        </div>
                        <div class="col-md-7">
                            <h2>{{ $product->name }}</h2>
                            <h5 class="font-weight-bold mb-3">
                                {{ \App\Helpers\BasicHelper::getRupiahFormat($product->price) }}
                            </h5>
                            <h6 class="font-weight-bold">Description</h6>
                            <p>{!! nl2br(e($product->description)) !!}</p>

                            <h6 class="font-weight-bold">Type</h6>
                            <p>{{ $product->type->getTranslated() }}</p>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td class="text-center">Expired At</td>
                                            <td class="text-center">Amounts</td>
                                            <td class="text-center">Created At</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->productStocks as $stock)
                                            @if ($stock->quantity > 0)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $stock->expired_date ? $stock->expired_date->format('d F Y') : '-' }}
                                                    </td>
                                                    <td class="text-center">{{ number_format($stock->quantity) }}</td>
                                                    <td class="text-center">{{ $stock->created_at->format('d F Y H:i') }}</td>
                                                    <td>
                                                        <button type="button" class="border-0 badge bg-danger text-white" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $stock->id }}">
                                                            Delete
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="deleteModal-{{ $stock->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="deleteModalLabel">Delete Stock</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('products.stock', ['product' => $product, 'stock' => $stock]) }}" method="POST" id="deleteForm-{{ $stock->id }}">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <div class="mb-3">
                                                                                <label for="reason" class="form-label">Reason</label>
                                                                                <select class="form-control" name="reason" id="reason" required>
                                                                                    <option value="" hidden>Choose Reason</option>
                                                                                    <option value="Broken">Broken</option>
                                                                                    <option value="Lost">Lost</option>
                                                                                    <option value="Return">Return</option>
                                                                                </select>
                                                                            </div>
                                                                        </form>
                                                                        Are you sure to delete this stock?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="submit" class="btn btn-danger" onclick="document.getElementById('deleteForm-{{ $stock->id }}').submit();">Delete</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <div class="btn-group">
                        <a href="{{ route('products.index') }}" class="btn btn-danger font-weight-bold">
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
@endpush
