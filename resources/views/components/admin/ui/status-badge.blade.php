@props([
    'type' => 'secondary',
])

<span {{ $attributes->class(["badge text-bg-{$type}"]) }}>
    {{ $slot }}
</span>