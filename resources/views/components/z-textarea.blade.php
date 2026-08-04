@props([
    'name',
    'label',
    'value' => null,
    'required' => false,
    'help' => null,
    'rows' => 4,
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

    <textarea
        name="{{ $name }}"
        id="{{ $inputId }}"
        rows="{{ $rows }}"
        @required($required)
        {{ $attributes
            ->except(['id'])
            ->class([
                'form-control',
                'is-invalid' => $hasError,
            ])
        }}
    >{{ old($name, $value) }}</textarea>

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