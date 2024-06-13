@extends('layouts.app')

@section('content')
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

    <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
        @foreach ($products as $product)
            <div class="col mb-4">
                <div class="card h-100">
                    <img src="{{ $product->getPhoto() }}" class="card-img-top" alt="Product Photo"
                        style="aspect-ratio: 16 / 9; object-fit: cover;" />
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text" style="height: 10rem;">{!! str(nl2br(e($product->description)))->words(20) !!}</p>
                        <ul>
                            <li>Stocks: {{ number_format($product->product_stocks_sum_quantity ?? 0) }}</li>
                            @if ($product->last_new_stocks)
                                <li>New Stocks: {{ number_format($product->last_new_stocks) }}</li>
                            @else
                                <li>New Stocks: -</li>
                            @endif
                        </ul>
                        <div class="row">
                            <div class="col-sm-6">
                                @if (($product->product_stocks_sum_quantity ?? 0) > 10)
                                    <span class="btn d-block btn-outline-success no-hover">Available</span>
                                @elseif (($product->product_stocks_sum_quantity ?? 0) == 0)
                                    <span class="btn d-block btn-outline-danger no-hover">Empty</span>
                                @else
                                    <span class="btn d-block btn-outline-warning no-hover">Almost Empty</span>
                                @endif
                            </div>     
                            <div class="col-sm-6">
                                <a href="{{ route('products.detail', $product) }}" class="btn d-block btn-info">Detail</a>
                            </div>
                            <div class="col-sm-12 my-3">
                                {{ $product->type }}
                                @if ($product->type == 'medicine')
                                <a href="{{ route('products.transaction', $product) }}" class="btn d-block btn-success">Decrease Stock</a>
                            @else
                                <a href="{{ route('products.transaction', $product) }}" class="btn d-block btn-success">Trasaction</a>
                            @endif
                            </div>
                        </div>
                        <p class="card-text"><small class="text-muted">Last updated
                                at {{ $product->updated_at->diffForHumans() }}</small>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row py-4">
        <div class="col">
            {{ $products->links() }}
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
        integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async>
    </script>
@endpush
