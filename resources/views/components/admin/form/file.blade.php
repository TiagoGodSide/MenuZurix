@props([
    'name',
    'label',
    'multiple' => false,
    'accept' => null,
    'help' => null,
])

@php
    $inputId = $attributes->get('id', $name);
    $errorField = $multiple
        ? str_replace('[]', '', $name).'.*'
        : $name;

    $hasError = $errors->has($name)
        || $errors->has($errorField);
@endphp

<div>
    <label for="{{ $inputId }}" class="form-label">
        {{ $label }}
    </label>

    <input
        type="file"
        name="{{ $name }}"
        id="{{ $inputId }}"
        @if ($multiple) multiple @endif
        @if ($accept) accept="{{ $accept }}" @endif
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

    @error($errorField)
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