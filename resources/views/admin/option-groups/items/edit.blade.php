@extends('layouts.admin')

@section('title', 'Editar item')
@section('page-title', 'Editar item')

@section('breadcrumb')
    Grupos de opções /
    {{ $optionGroup->name }} /
    Editar item
@endsection

@section('content')

<div class="mb-3">
    <a
        href="{{ route(
            'admin.option-groups.items.index',
            $optionGroup
        ) }}"
        class="text-decoration-none"
    >
        <i class="bi bi-arrow-left me-1"></i>
        Voltar para {{ $optionGroup->name }}
    </a>
</div>

<div class="card content-card mb-4">

    <div class="card-body">

        <div class="d-flex align-items-center gap-3">

            <div
                class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white"
                style="width: 48px; height: 48px;"
            >
                <i class="bi bi-pencil fs-5"></i>
            </div>

            <div>
                <h2 class="h5 mb-1">
                    Editar item
                </h2>

                <div class="text-muted">
                    Grupo:
                    <strong>
                        {{ $optionGroup->name }}
                    </strong>
                </div>
            </div>

        </div>

    </div>

</div>

<form
    action="{{ route(
        'admin.option-groups.items.update',
        [
            'optionGroup' => $optionGroup,
            'optionItem' => $optionItem,
        ]
    ) }}"
    method="POST"
>
    @csrf
    @method('PUT')

    @include(
        'admin.option-groups.items._form'
    )

</form>

@endsection