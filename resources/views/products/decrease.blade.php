@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-7 col-lg-8">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form {{ $title }}</h6>
                </div>
                <form action="{{ route('products.decrease', $product) }}" method="post">
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
                        <div class="mb-3">
                            <x-forms.label id="name">Price</x-forms.label>
                            <x-forms.input name="name" readonly disabled :value="old('price', $product->price)" />
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-forms.label id="date">Date</x-forms.label>
                                    <x-forms.input type="date" name="date" :value="old('date')" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-forms.label id="quantity">Quantity</x-forms.label>
                                    <x-forms.input type="number" name="quantity" :value="old('quantity', 0)" id="quantity" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <x-forms.label id="total">Total</x-forms.label>
                            <x-forms.input type="number" name="total" :value="old('total', 0)" id="total" />
                        </div>

                        <div class="mb-3">
                                <x-forms.label id="reason">Reason</x-forms.label>
                                <x-forms.textarea name="reason" :value="old('reason')"></x-forms.textarea>
                        </div>
                    </div>

                    
                    <div class="card-footer d-flex justify-content-end">
                        <div class="btn-group">
                            <a href="{{ route('dashboard.index') }}" class="btn btn-danger font-weight-bold">
                                Cancel</a>
                            <button type="submit" class="btn btn-primary font-weight-bold">
                                Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        const quantityInput = document.getElementById('quantity');
        const totalInput = document.getElementById('total');

        quantityInput.addEventListener('input', (e) => {
            const total = e.target.value * {{ $product->price ?? 0 }}
            totalInput.value = total;
        });
    </script>
@endpush
