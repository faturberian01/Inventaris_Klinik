@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-7 col-lg-8">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form {{ $title }}</h6>
                </div>
                <form action="{{ route('stocks.add', $product) }}" method="post">
                    @csrf

                    <div class="card-body">
                        <div class="mb-3">
                            <x-forms.label id="code">Code</x-forms.label>
                            <x-forms.input name="code" readonly disabled :value="old('code', $product->code)" />
                        </div>

                        <div class="mb-3">
                            <x-forms.label id="name">Name</x-forms.label>
                            <x-forms.input name="name" readonly disabled :value="old('name', $product->name)" />
                        </div>

                        <div class="mb-3">
                            <x-forms.label id="description">Description</x-forms.label>
                            <x-forms.textarea name="description" readonly
                                disabled>{{ old('description', $product->description) }}</x-forms.textarea>
                        </div>

                        @if ($product->type === \App\Enums\ProductType::MEDICINE)
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <x-forms.label id="expired_date">Expired Date</x-forms.label>
                                        <x-forms.input type="date" name="expired_date" :value="old('expired_date')" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <x-forms.label id="quantity">Quantity</x-forms.label>
                                        <x-forms.input type="number" name="quantity" :value="old('quantity', 0)" />
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <x-forms.label id="quantity">Quantity</x-forms.label>
                                <x-forms.input type="number" name="quantity" :value="old('quantity', 0)" />
                            </div>
                        @endif

                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <div class="">
                            <a href="{{ route('stocks.index') }}" class="btn btn-danger font-weight-bold">
                                Cancel</a>
                            <button type="submit" class="btn btn-primary font-weight-bold me-2">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
