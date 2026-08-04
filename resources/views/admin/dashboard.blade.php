@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

    <div class="row">

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>0</h3>

                    <p>Pedidos hoje</p>
                </div>

                <div class="small-box-icon">
                    <i class="bi bi-cart-check"></i>
                </div>

                <a
                    href="#"
                    class="small-box-footer link-light"
                >
                    Ver pedidos
                    <i class="bi bi-arrow-right-circle ms-1"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>0</h3>

                    <p>Aguardando confirmação</p>
                </div>

                <div class="small-box-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>

                <a
                    href="#"
                    class="small-box-footer link-dark"
                >
                    Ver pendentes
                    <i class="bi bi-arrow-right-circle ms-1"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-info">
                <div class="inner">
                    <h3>0</h3>

                    <p>Em preparação</p>
                </div>

                <div class="small-box-icon">
                    <i class="bi bi-fire"></i>
                </div>

                <a
                    href="#"
                    class="small-box-footer link-dark"
                >
                    Acompanhar
                    <i class="bi bi-arrow-right-circle ms-1"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>R$ 0,00</h3>

                    <p>Vendas de hoje</p>
                </div>

                <div class="small-box-icon">
                    <i class="bi bi-cash-coin"></i>
                </div>

                <a
                    href="#"
                    class="small-box-footer link-light"
                >
                    Ver detalhes
                    <i class="bi bi-arrow-right-circle ms-1"></i>
                </a>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-8">

            <div class="card content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-receipt me-2"></i>
                        Últimos pedidos
                    </h3>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Pedido</th>
                                    <th>Cliente</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td
                                        colspan="5"
                                        class="text-center text-muted py-5"
                                    >
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                                        Nenhum pedido recebido.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4">

            <div class="card content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-lightning-charge me-2"></i>
                        Ações rápidas
                    </h3>
                </div>

                <div class="card-body d-grid gap-2">
                  <a
                    href="{{ route('admin.products.create') }}"
                    class="btn btn-primary"
                >
                    <i class="bi bi-plus-circle me-2"></i>
                    Cadastrar produto
                </a>
                
                   <a
                        href="{{ route('admin.categories.create') }}"
                        class="btn btn-outline-primary"
                    >
                        <i class="bi bi-tag me-2"></i>
                        Cadastrar categoria
                    </a>
                    
                    <a
                        href="{{ route('site.home') }}"
                        target="_blank"
                        class="btn btn-outline-secondary"
                    >
                        <i class="bi bi-eye me-2"></i>
                        Visualizar cardápio
                    </a>
                </div>
            </div>

            <div class="card content-card mt-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-shop me-2"></i>
                        Situação da loja
                    </h3>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <strong>Recebimento de pedidos</strong>

                            <div class="text-muted small">
                            {{ $business?->name ?? 'Nenhum negócio vinculado' }}
                        </div>
                        </div>

                       @if ($business)
                    <span class="badge {{ $business->status->badgeClass() }}">
                        {{ $business->status->label() }}
                    </span>
                @else
                    <span class="badge text-bg-danger">
                        Não configurada
                    </span>
                @endif
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection