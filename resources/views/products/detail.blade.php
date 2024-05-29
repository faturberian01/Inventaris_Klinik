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
                                            <tr>
                                                <td class="text-center">
                                                    {{ $stock->expired_date?->format('d F Y ') ?? '-' }}
                                                </td>
                                                <td class="text-center">{{ number_format($stock->quantity) }}</td>
                                                <td class="text-center">{{ $stock->created_at->format('d F Y H:i') }}
                                                </td>
                                                <td>
                                                    <form
                                                        action="{{ route('products.stock', [
                                                            'product' => $product,
                                                            'stock' => $stock,
                                                        ]) }}"
                                                        onsubmit="return confirm('Are you sure to delete this stock?')"
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

                <div class="card-footer d-flex justify-content-end">
                    <div class="btn-group">
                        <a href="{{ route('products.index') }}" class="btn btn-danger font-weight-bold">
                            Back</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
