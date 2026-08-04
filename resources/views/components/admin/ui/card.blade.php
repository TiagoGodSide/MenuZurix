@props([
    'title',
    'icon' => null,
])

<div {{ $attributes->class(['card content-card mb-4']) }}>
    <div class="card-header">
        <h3 class="card-title">
            @if ($icon)
                <i class="bi {{ $icon }} me-2"></i>
            @endif

            {{ $title }}
        </h3>

        @isset($actions)
            <div class="card-tools">
                {{ $actions }}
            </div>
        @endisset
    </div>

    <div class="card-body">
        {{ $slot }}
    </div>
</div>