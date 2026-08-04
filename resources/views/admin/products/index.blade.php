@extends('layouts.admin')

@section('title', 'Produtos')
@section('page-title', 'Produtos')

@section('breadcrumb')
    <li class="breadcrumb-item active">
        Produtos
    </li>
@endsection

@section('content')
    <div class="card content-card">
        <div class="card-header">
            <form
                action="{{ route('admin.products.index') }}"
                method="GET"
                class="row g-2"
            >
                <div class="col-lg-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Nome, SKU ou descrição"
                            class="form-control"
                        >
                    </div>
                </div>

                <div class="col-lg-2">
                    <select
                        name="category_id"
                        class="form-select"
                    >
                        <option value="">
                            Todas as categorias
                        </option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected($categoryId === $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2">
                    <select
                        name="status"
                        class="form-select"
                    >
                        <option value="">
                            Todos os status
                        </option>

                        <option value="active" @selected($status === 'active')>
                            Ativos
                        </option>

                        <option value="inactive" @selected($status === 'inactive')>
                            Inativos
                        </option>

                        <option value="available" @selected($status === 'available')>
                            Disponíveis
                        </option>

                        <option value="sold_out" @selected($status === 'sold_out')>
                            Esgotados
                        </option>
                    </select>
                </div>

                <div class="col-lg-2">
                    <select
                        name="featured"
                        class="form-select"
                    >
                        <option value="">
                            Todos
                        </option>

                        <option value="yes" @selected($featured === 'yes')>
                            Em destaque
                        </option>
                    </select>
                </div>

                <div class="col-lg-3">
                    <div class="d-flex gap-2">
                        <button
                            type="submit"
                            class="btn btn-outline-secondary flex-fill"
                        >
                            Filtrar
                        </button>

                        <a
                            href="{{ route('admin.products.create') }}"
                            class="btn btn-primary flex-fill"
                        >
                            <i class="bi bi-plus-circle me-1"></i>
                            Novo produto
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 90px;">Imagem</th>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Situação</th>
                            <th class="text-end" style="width: 250px;">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    @if ($product->primaryImage)
                                        <img
                                            src="{{ asset('storage/'.$product->primaryImage->image_path) }}"
                                            alt="{{ $product->name }}"
                                            class="rounded border"
                                            style="width: 64px; height: 64px; object-fit: cover;"
                                        >
                                    @else
                                        <div
                                            class="rounded border bg-body-secondary d-flex align-items-center justify-content-center"
                                            style="width: 64px; height: 64px;"
                                        >
                                            <i class="bi bi-image text-muted fs-4"></i>
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <strong>{{ $product->name }}</strong>

                                    @if ($product->sku)
                                        <div class="small text-muted">
                                            SKU: {{ $product->sku }}
                                        </div>
                                    @endif

                                    @if ($product->is_featured)
                                        <span class="badge text-bg-primary mt-1">
                                            Destaque
                                        </span>
                                    @endif

                                    @if ($product->is_product_of_the_day)
                                        <span class="badge text-bg-warning mt-1">
                                            Produto do dia
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $product->category->name }}
                                </td>

                                <td>
                                    @if ($product->hasPromotion())
                                        <div class="text-muted text-decoration-line-through small">
                                            R$ {{ number_format((float) $product->price, 2, ',', '.') }}
                                        </div>

                                        <strong class="text-success">
                                            R$ {{ number_format((float) $product->promotional_price, 2, ',', '.') }}
                                        </strong>
                                    @else
                                        <strong>
                                            R$ {{ number_format((float) $product->price, 2, ',', '.') }}
                                        </strong>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex flex-column align-items-start gap-1">
                                        @if ($product->is_active)
                                            <span class="badge text-bg-success">
                                                Ativo
                                            </span>
                                        @else
                                            <span class="badge text-bg-secondary">
                                                Inativo
                                            </span>
                                        @endif

                                        @if ($product->is_sold_out)
                                            <span class="badge text-bg-danger">
                                                Esgotado
                                            </span>
                                        @elseif (! $product->is_available)
                                            <span class="badge text-bg-warning">
                                                Indisponível
                                            </span>
                                        @else
                                            <span class="badge text-bg-info">
                                                Disponível
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a
                                            href="{{ route('admin.products.edit', $product) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Editar"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form
                                            action="{{ route('admin.products.toggle-status', $product) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-secondary"
                                                title="{{ $product->is_active ? 'Desativar' : 'Ativar' }}"
                                            >
                                                <i class="bi {{ $product->is_active ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                            </button>
                                        </form>

                                        <form
                                            action="{{ route('admin.products.toggle-sold-out', $product) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-warning"
                                                title="{{ $product->is_sold_out ? 'Disponibilizar novamente' : 'Marcar como esgotado' }}"
                                            >
                                                <i class="bi bi-exclamation-triangle"></i>
                                            </button>
                                        </form>

                                        <form
                                            action="{{ route('admin.products.duplicate', $product) }}"
                                            method="POST"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-info"
                                                title="Duplicar produto"
                                            >
                                                <i class="bi bi-copy"></i>
                                            </button>
                                        </form>

                                        <form
                                            action="{{ route('admin.products.destroy', $product) }}"
                                            method="POST"
                                            onsubmit="return confirm('Arquivar este produto?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Arquivar"
                                            >
                                                <i class="bi bi-archive"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="6"
                                    class="text-center text-muted py-5"
                                >
                                    <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                                    Nenhum produto encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($products->hasPages())
            <div class="card-footer">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection