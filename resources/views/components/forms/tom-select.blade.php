@props(['id', 'name', 'value' => '', 'placeholder' => 'Pilih...', 'withInitScript' => true])

<select id="{{ $id ?? $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'form-control ' .
    ($errors->has($name) ? 'is-invalid' : '')
    ]) }}
    placeholder="{{ $placeholder }}" autocomplete="off">
    <option value="">{{ $placeholder }}</option>
    {{ $slot }}
</select>

@error($name)
<div id="{{ $id ?? $name }}" class="invalid-feedback">
    {{ $message }}
</div>
@enderror

@if($withInitScript)
@push('script')
<script>
    const {{ $id ?? $name }}TomSelect = new TomSelect("#{{ $id ?? $name }}");
</script>
@endpush
@endif