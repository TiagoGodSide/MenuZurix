@extends('layouts.admin')

@section('title', 'Categorias')
@section('page-title', 'Categorias')

@section('breadcrumb')
    <li class="breadcrumb-item active">
        Categorias
    </li>
@endsection

@section('content')
    <div class="card content-card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3">

                <form
                    action="{{ route('admin.categories.index') }}"
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
                                placeholder="Pesquisar categoria"
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
                                Ativas
                            </option>

                            <option
                                value="inactive"
                                @selected($status === 'inactive')
                            >
                                Inativas
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
                    href="{{ route('admin.categories.create') }}"
                    class="btn btn-primary"
                >
                    <i class="bi bi-plus-circle me-2"></i>
                    Nova categoria
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 80px;">
                                Ordem
                            </th>

                            <th>Categoria</th>
                            <th>Identificador</th>
                            <th>Status</th>

                            <th
                                class="text-end"
                                style="width: 210px;"
                            >
                                Ações
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>
                                    {{ $category->sort_order }}
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <span
                                            class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                            style="
                                                width: 42px;
                                                height: 42px;
                                                color: white;
                                                background: {{ $category->color }};
                                            "
                                        >
                                            <i class="{{ $category->icon ?: 'bi bi-tag' }}"></i>
                                        </span>

                                        <div>
                                            <strong>
                                                {{ $category->name }}
                                            </strong>

                                            @if ($category->description)
                                                <div class="small text-muted">
                                                    {{ \Illuminate\Support\Str::limit($category->description, 70) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <code>
                                        {{ $category->slug }}
                                    </code>
                                </td>

                                <td>
                                    @if ($category->is_active)
                                        <span class="badge text-bg-success">
                                            Ativa
                                        </span>
                                    @else
                                        <span class="badge text-bg-secondary">
                                            Inativa
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">

                                        <form
                                            action="{{ route('admin.categories.toggle-status', $category) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-secondary"
                                                title="{{ $category->is_active ? 'Desativar' : 'Ativar' }}"
                                            >
                                                <i class="bi {{ $category->is_active ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                            </button>
                                        </form>

                                        <a
                                            href="{{ route('admin.categories.edit', $category) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Editar"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form
                                            action="{{ route('admin.categories.destroy', $category) }}"
                                            method="POST"
                                            onsubmit="return confirm('Excluir esta categoria?');"
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
                                    <i class="bi bi-tags fs-1 d-block mb-2"></i>

                                    Nenhuma categoria encontrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($categories->hasPages())
            <div class="card-footer">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
@endsection