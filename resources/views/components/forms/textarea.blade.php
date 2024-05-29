@props(['id', 'name'])

<textarea class="form-control" id="{{ $id ?? $name }}" name="{{ $name }}" {{ $attributes }}>{{ $slot }}</textarea>

@error($name)
<small id="{{ $id ?? $name }}" class="font-weight-bold text-danger d-block mt-2">
    {{ $message }}
</small>
@enderror