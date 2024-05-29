@props(['id', 'required' => true])
<label for="{{ $id }}" class="font-weight-bold">{{ $slot }} @if ($required)
    <sup class="text-danger">*</sup>
    @endif</label>