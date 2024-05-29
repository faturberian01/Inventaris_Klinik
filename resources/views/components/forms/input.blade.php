@props(['id', 'name', 'value' => '', 'type' => 'text'])

<input type="{{ $type }}" {{ $attributes->merge(['class' => 'form-control bg-light']) }} id="{{ $id ?? $name }}"
name="{{ $name }}" value="{{ $value }}" {{ $attributes }} />

@error($name)
<small id="{{ $id ?? $name }}" class="font-weight-bold text-danger d-block mt-2">
    {{ $message }}
</small>
@enderror