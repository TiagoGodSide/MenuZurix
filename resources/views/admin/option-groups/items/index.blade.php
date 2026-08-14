@extends('layouts.admin')

@section('title', 'Itens - '.$optionGroup->name)
@section('page-title', 'Itens do grupo')

@section('breadcrumb')
    Grupos de opções /
    {{ $optionGroup->name }}
@endsection

@section('content')

<div class="card content-card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="card-title mb-1">
                {{ $optionGroup->name }}
            </h3>

            @if ($optionGroup->description)
                <div class="text-muted small">
                    {{ $optionGroup->description }}
                </div>
            @endif
        </div>

        <a
            href="{{ route(
                'admin.option-groups.items.create',
                $optionGroup
            ) }}"
            class="btn btn-primary"
        >
            <i class="bi bi-plus-circle me-2"></i>
            Novo item
        </a>
    </div>

    <div class="card-body">

        @if ($items->count())

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Preço adicional</th>
                            <th>Quantidade máxima</th>
                            <th>Status</th>
                            <th class="text-end">
                                Ações
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($items as $item)

                            <tr>

                                <td>
                                    <strong>
                                        {{ $item->name }}
                                    </strong>

                                    @if ($item->description)
                                        <div class="small text-muted">
                                            {{ $item->description }}
                                        </div>
                                    @endif

                                    @if ($item->is_default)
                                        <span class="badge text-bg-info mt-1">
                                            Padrão
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($item->isFree())
                                        Grátis
                                    @else
                                        R$
                                        {{ number_format(
                                            (float) $item->additional_price,
                                            2,
                                            ',',
                                            '.'
                                        ) }}
                                    @endif
                                </td>

                                <td>
                                    {{ $item->max_quantity }}
                                </td>

                                <td>
                                    @if ($item->is_active)
                                        <span class="badge text-bg-success">
                                            Ativo
                                        </span>
                                    @else
                                        <span class="badge text-bg-secondary">
                                            Inativo
                                        </span>
                                    @endif
                                </td>

                        <td class="text-end">
                            <div class="d-inline-flex gap-1">

                                {{-- Editar --}}
                                <a
                                    href="{{ route(
                                        'admin.option-groups.items.edit',
                                        [
                                            'optionGroup' => $optionGroup,
                                            'optionItem' => $item,
                                        ]
                                    ) }}"
                                    class="btn btn-sm btn-outline-primary"
                                    title="Editar"
                                >
                                    <i class="bi bi-pencil"></i>
                                </a>

                                {{-- Ativar / Desativar --}}
                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.option-groups.items.toggle-status',
                                        [
                                            'optionGroup' => $optionGroup,
                                            'optionItem' => $item,
                                        ]
                                    ) }}"
                                    class="d-inline"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="btn btn-sm {{ $item->is_active
                                            ? 'btn-outline-danger'
                                            : 'btn-outline-success' }}"
                                        title="{{ $item->is_active
                                            ? 'Desativar item'
                                            : 'Ativar item' }}"
                                    >
                                        <i class="bi {{ $item->is_active
                                            ? 'bi-toggle-off'
                                            : 'bi-toggle-on' }}"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>

        @else

            <div class="text-center text-muted py-5">

                <i class="bi bi-list-check fs-1 d-block mb-3"></i>

                <h5>
                    Nenhum item cadastrado.
                </h5>

                <p class="mb-3">
                    Cadastre as opções disponíveis para este grupo.
                </p>

                <a
                    href="{{ route(
                        'admin.option-groups.items.create',
                        $optionGroup
                    ) }}"
                    class="btn btn-primary"
                >
                    <i class="bi bi-plus-circle me-2"></i>
                    Cadastrar primeiro item
                </a>

            </div>

        @endif

    </div>

    @if ($items->hasPages())
        <div class="card-footer">
            {{ $items->links() }}
        </div>
    @endif

</div>

@endsection