@extends('layouts.admin')

@section('title', 'Grupos de opções')
@section('page-title', 'Grupos de opções')

@section('breadcrumb')

Grupos de opções

@endsection

@section('content')

<div class="card content-card">

    <div class="card-header">
        <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-md-center">

            <form
                action="{{ route('admin.option-groups.index') }}"
                method="GET"
                class="row g-2 flex-grow-1"
            >

                <div class="col-md-6">

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Pesquisar grupo de opções"
                            class="form-control"
                        >

                    </div>

                </div>


                <div class="col-md-3">

                    <select
                        name="status"
                        class="form-select"
                    >

                        <option value="">
                            Todos os status
                        </option>

                        <option
                            value="active"
                            @selected($status === 'active')
                        >
                            Ativos
                        </option>

                        <option
                            value="inactive"
                            @selected($status === 'inactive')
                        >
                            Inativos
                        </option>

                    </select>

                </div>


                <div class="col-md-auto">

                    <button
                        type="submit"
                        class="btn btn-outline-secondary"
                    >
                        Filtrar
                    </button>

                </div>

            </form>


            <a
                href="{{ route('admin.option-groups.create') }}"
                class="btn btn-primary"
            >

                <i class="bi bi-plus-circle me-2"></i>

                Novo grupo

            </a>

        </div>
    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>

                        <th>
                            Grupo de opções
                        </th>

                        <th>
                            Tipo de escolha
                        </th>

                        <th>
                            Itens
                        </th>

                        <th>
                            Status
                        </th>

                        <th
                            class="text-end"
                            style="width: 210px;"
                        >
                            Ações
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($optionGroups as $optionGroup)

                        <tr>

                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    <span
                                        class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                        style="
                                            width: 42px;
                                            height: 42px;
                                            color: white;
                                            background: #0d6efd;
                                        "
                                    >
                                        <i class="bi bi-ui-checks"></i>
                                    </span>

                                    <div>

                                        <strong>
                                            {{ $optionGroup->name }}
                                        </strong>


                                        @if ($optionGroup->description)

                                            <div class="small text-muted">

                                                {{ \Illuminate\Support\Str::limit(
                                                    $optionGroup->description,
                                                    70
                                                ) }}

                                            </div>

                                        @endif

                                    </div>

                                </div>

                            </td>


                            <td>

                                @if ($optionGroup->selection_type === 'single')

                                    <span class="badge text-bg-light border">

                                        <i class="bi bi-circle me-1"></i>

                                        Escolha única

                                    </span>

                                @else

                                    <span class="badge text-bg-light border">

                                        <i class="bi bi-check2-square me-1"></i>

                                        Múltiplas escolhas

                                    </span>

                                @endif

                            </td>


                            <td>

                                {{ $optionGroup->items_count }}

                            </td>


                            <td>

                                @if ($optionGroup->is_active)

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
                                            'admin.option-groups.toggle-status',
                                            $optionGroup
                                        ) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('PATCH')


                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-secondary"
                                            title="{{ $optionGroup->is_active ? 'Desativar' : 'Ativar' }}"
                                        >

                                            <i class="bi {{
                                                $optionGroup->is_active
                                                    ? 'bi-eye-slash'
                                                    : 'bi-eye'
                                            }}"></i>

                                        </button>

                                        <a
                                            href="{{ route(
                                                'admin.option-groups.items.index',
                                                $optionGroup
                                            ) }}"
                                            class="btn btn-sm btn-outline-success"
                                            title="Gerenciar itens"
                                        >
                                            <i class="bi bi-list-check"></i>
                                        </a>

                                    </form>


                                    <a
                                        href="{{ route(
                                            'admin.option-groups.edit',
                                            $optionGroup
                                        ) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Editar"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    <form
                                        action="{{ route(
                                            'admin.option-groups.destroy',
                                            $optionGroup
                                        ) }}"
                                        method="POST"
                                        onsubmit="return confirm(
                                            'Excluir este grupo de opções? Os itens vinculados também serão excluídos.'
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
                                colspan="5"
                                class="text-center text-muted py-5"
                            >

                                <i class="bi bi-ui-checks fs-1 d-block mb-2"></i>

                                Nenhum grupo de opções encontrado.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    @if ($optionGroups->hasPages())

        <div class="card-footer">

            {{ $optionGroups->links() }}

        </div>

    @endif

</div>

@endsection