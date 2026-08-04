@if ($errors->any())
    <div {{ $attributes->class(['alert alert-danger']) }}>
        <strong>
            {{ $title ?? 'Não foi possível salvar.' }}
        </strong>

        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif