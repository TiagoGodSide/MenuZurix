@props([
    'name',
    'label',
    'checked' => false,
    'help' => null,
])

@php
    $inputId = $attributes->get('id', $name);
    $isChecked = (bool) old($name, $checked);
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
            name="{{ $name }}"
            id="{{ $inputId }}"
            value="1"
            @checked($isChecked)
            {{ $attributes
                ->except(['id'])
                ->class(['form-check-input'])
            }}
        >

        <label
            for="{{ $inputId }}"
            class="form-check-label"
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