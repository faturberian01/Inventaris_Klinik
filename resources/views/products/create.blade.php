@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-7 col-lg-8">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form {{ $title }}</h6>
                </div>
                <form action="{{ route('products.store') }}" method="post" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="mb-3">
                            <x-forms.label id="code">Code</x-forms.label>
                            <x-forms.input name="code" :value="old('code')" />
                        </div>

                        <div class="mb-3">
                            <x-forms.label id="name">Name</x-forms.label>
                            <x-forms.input name="name" :value="old('name')" />
                        </div>

                        <div class="mb-3">
                            <x-forms.label id="description">Description</x-forms.label>
                            <x-forms.textarea name="description">{{ old('description') }}</x-forms.textarea>
                        </div>

                        <div class="mb-3">
                            <x-forms.label id="price">Price</x-forms.label>
                            <x-forms.input type="number" name="price" :value="old('price')" />
                        </div>

                        <div class="mb-3">
                            <x-forms.label id="type">Type</x-forms.label>
                            <x-forms.select name="type">
                                @foreach (\App\Enums\ProductType::getList() as $key => $label)
                                    <option value="{{ $key }}" @selected($key == old('type'))>{{ $label }}
                                    </option>
                                @endforeach
                            </x-forms.select>
                        </div>

                        <div class="mb-3">
                            <x-forms.label id="photo">Photo</x-forms.label>
                            <x-forms.input type="file" name="photo" :value="old('photo')" />
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <div class="btn-group">
                            <a href="{{ route('products.index') }}" class="btn btn-danger font-weight-bold">
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
