@props([
    'name',
    'label',
    'checked' => false,
    'help' => null,
])

@php
    $inputId = $attributes->get('id', $name);
@endphp

<div>

    <input
        type="hidden"
        name="{{ $name }}"
        value="0"
    >

    <div class="form-check form-switch">

        <input
            type="checkbox"
            class="form-check-input"
            name="{{ $name }}"
            id="{{ $inputId }}"
            value="1"
            @checked(old($name, $checked))
        >

        <label
            class="form-check-label"
            for="{{ $inputId }}"
        >
            {{ $label }}
        </label>

    </div>

    @if ($help)
        <div class="form-text">
            {{ $help }}
        </div>
    @endif

</div>