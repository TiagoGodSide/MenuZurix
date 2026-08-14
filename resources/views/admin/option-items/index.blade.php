@extends('layouts.admin')

@section('title', 'Itens - ' . $optionGroup->name)
@section('page-title', 'Itens do grupo')

@section('breadcrumb')
    Grupos de opções / {{ $optionGroup->name }} / Itens
@endsection

@section('content')

<div class="card content-card">

    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

            <div>
                <h3 class="card-title mb-1">
                    <i class="bi bi-list-check me-2"></i>
                    {{ $optionGroup->name }}
                </h3>

                @if ($optionGroup->description)
                    <div class="small text-muted">
                        {{ $optionGroup->description }}
                    </div>
                @endif
            </div>

            <div class="d-flex gap-2">

                <a
                    href="{{ route('admin.option-groups.index') }}"
                    class="btn btn-outline-secondary"
                >
                    <i class="bi bi-arrow-left me-2"></i>
                    Voltar
                </a>

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

        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3 mb-0">
            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3 mb-0">
            <i class="bi bi-exclamation-circle me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>

                        <th style="width: 80px;">
                            Ordem
                        </th>

                        <th>
                            Item
                        </th>

                        <th>
                            Acréscimo
                        </th>

                        <th>
                            Máx. quantidade
                        </th>

                        <th>
                            Padrão
                        </th>

                        <th>
                            Status
                        </th>

                        <th
                            class="text-end"
                            style="width: 180px;"
                        >
                            Ações
                        </th>

                    </tr>
                </thead>

                <tbody>

                    @forelse ($items as $item)

                        <tr>

                            <td>
                                {{ $item->sort_order }}
                            </td>

                            <td>

                                <div>
                                    <strong>
                                        {{ $item->name }}
                                    </strong>

                                    @if ($item->description)
                                        <div class="small text-muted">
                                            {{ \Illuminate\Support\Str::limit(
                                                $item->description,
                                                80
                                            ) }}
                                        </div>
                                    @endif
                                </div>

                            </td>

                            <td>

                                @if ($item->isFree())

                                    <span class="text-muted">
                                        Grátis
                                    </span>

                                @else

                                    <strong>
                                        R$
                                        {{ number_format(
                                            (float) $item->additional_price,
                                            2,
                                            ',',
                                            '.'
                                        ) }}
                                    </strong>

                                @endif

                            </td>

                            <td>
                                {{ $item->max_quantity }}
                            </td>

                            <td>

                                @if ($item->is_default)

                                    <span class="badge text-bg-info">
                                        Sim
                                    </span>

                                @else

                                    <span class="text-muted">
                                        Não
                                    </span>

                                @endif

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

                                    <form
                                        action="{{ route(
                                            'admin.option-groups.items.toggle-status',
                                            [
                                                'optionGroup' => $optionGroup,
                                                'optionItem' => $item,
                                            ]
                                        ) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-secondary"
                                            title="{{ $item->is_active
                                                ? 'Desativar'
                                                : 'Ativar'
                                            }}"
                                        >

                                            <i class="bi {{
                                                $item->is_active
                                                    ? 'bi-eye-slash'
                                                    : 'bi-eye'
                                            }}"></i>

                                        </button>

                                    </form>

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

                                    <form
                                        action="{{ route(
                                            'admin.option-groups.items.destroy',
                                            [
                                                'optionGroup' => $optionGroup,
                                                'optionItem' => $item,
                                            ]
                                        ) }}"
                                        method="POST"
                                        onsubmit="return confirm(
                                            'Excluir este item?'
                                        );"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Excluir"
                                        >

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center text-muted py-5"
                            >

                                <i
                                    class="bi bi-list-check fs-1 d-block mb-2"
                                ></i>

                                <div class="fw-semibold">
                                    Nenhum item cadastrado.
                                </div>

                                <div class="small mt-1">
                                    Cadastre o primeiro item deste grupo.
                                </div>

                                <a
                                    href="{{ route(
                                        'admin.option-groups.items.create',
                                        $optionGroup
                                    ) }}"
                                    class="btn btn-primary btn-sm mt-3"
                                >
                                    <i class="bi bi-plus-circle me-2"></i>
                                    Novo item
                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    @if ($items->hasPages())

        <div class="card-footer">
            {{ $items->links() }}
        </div>

    @endif

</div>

@endsection