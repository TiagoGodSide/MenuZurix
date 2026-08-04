@props([
    'name',
    'label',
    'value' => null,
    'required' => false,
    'help' => null,
])

@php
    $inputId = $attributes->get('id', $name);
    $hasError = $errors->has($name);
    $selectedValue = old($name, $value);
@endphp

<div>
    <label
        for="{{ $inputId }}"
        class="form-label"
    >
        {{ $label }}

        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <select
        name="{{ $name }}"
        id="{{ $inputId }}"
        @required($required)
        {{ $attributes
            ->except(['id'])
            ->class([
                'form-select',
                'is-invalid' => $hasError,
            ])
        }}
    >
        {{ $slot }}
    </select>

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

    @if ($help)
        <div class="form-text">
            {{ $help }}
        </div>
    @endif
</div>