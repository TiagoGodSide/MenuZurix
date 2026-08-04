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
@endphp

<div>
    <label for="{{ $inputId }}" class="form-label">
        {{ $label }}

        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <div class="input-group">
        <span class="input-group-text">R$</span>

        <input
            type="number"
            name="{{ $name }}"
            id="{{ $inputId }}"
            min="0"
            step="0.01"
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
    </div>

    @if ($help)
        <div class="form-text">
            {{ $help }}
        </div>
    @endif
</div>