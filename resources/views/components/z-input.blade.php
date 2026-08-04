@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'help' => null,
])

@php
    $inputId = $attributes->get('id', $name);
    $hasError = $errors->has($name);
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

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $inputId }}"
        value="{{ old($name, $value) }}"
        @required($required)
        {{ $attributes
            ->except(['id'])
            ->class([
                'form-control',
                'is-invalid' => $hasError,
            ])
        }}
    >

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