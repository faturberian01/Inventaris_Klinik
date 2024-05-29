@props(['id', 'name'])


<select {{ $attributes->merge(['class' => 'form-control bg-light']) }} id="{{ $id ?? $name }}"
    name="{{ $name }}" {{ $attributes }} >
    {{ $slot }}
</select>

@error($name)
<small id="{{ $id ?? $name }}" class="font-weight-bold text-danger d-block mt-2">
    {{ $message }}
</small>
@enderror