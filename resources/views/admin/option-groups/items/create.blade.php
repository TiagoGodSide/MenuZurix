@extends('layouts.admin')

@section('title', 'Novo item')
@section('page-title', 'Novo item')

@section('breadcrumb')
    Grupos de opções /
    {{ $optionGroup->name }} /
    Novo item
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
                <i class="bi bi-list-check fs-5"></i>
            </div>

            <div>
                <h2 class="h5 mb-1">
                    Novo item
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
        'admin.option-groups.items.store',
        $optionGroup
    ) }}"
    method="POST"
>
    @csrf

    @include(
        'admin.option-groups.items._form'
    )

</form>

@endsection