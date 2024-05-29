@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>

    <div class="row mb-3 justify-content-end">
        <div class="col-md-5 col-sm-6">
            <form action="">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">
                            <i class="fas fa-search fa-sm fa-fw"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" name="q" value="{{ request('q') }}" />
                </div>
            </form>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
                </div>
                <div class="card-body">
                    @foreach ($products as $product)
                        <div class="list-group">
                            <div class="list-group-item list-group-item-action mb-2">
                                <div class="d-md-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <img src="{{ $product->getPhoto() }}" alt="Product Photo" class="img-thumbnail"
                                            width="200" />
                                    </div>
                                    <div style="flex: 1;" class="p-3">
                                        <h5 class="mb-1">{{ $product->name }}
                                            <span
                                                class="badge badge-{{ $product->type->getColor() }} fw-bold">{{ $product->type->getTranslated() }}</span>
                                        </h5>
                                        <p class="mb-1" style="max-width: 50rem;">{!! str(nl2br(e($product->description)))->words(50) !!}</p>
                                    </div>
                                    <div>
                                        <span
                                            class="badge badge-light d-inline-block mr-3 border">{{ $product->product_stocks_sum_quantity ?? 0 }}</span>
                                        <a href="{{ route('stocks.add', $product) }}" class="btn btn-light border">Add
                                            Stock</a>
                                    </div>
                                </div>
                                {{-- <small>And some small print.</small> --}}
                            </div>
                        </div>
                    @endforeach

                    <div class="d-flex align-items-center justify-content-end py-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
