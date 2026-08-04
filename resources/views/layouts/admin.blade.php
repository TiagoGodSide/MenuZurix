<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>@yield('title', 'Administração') | MenuPro</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        {{-- Barra superior --}}
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link btn btn-link"
                            data-lte-toggle="sidebar"
                            aria-label="Abrir ou fechar menu"
                        >
                            <i class="bi bi-list"></i>
                        </button>
                    </li>

                    <li class="nav-item d-none d-md-block">
                        <a
                            href="{{ route('site.home') }}"
                            target="_blank"
                            class="nav-link"
                        >
                            <i class="bi bi-box-arrow-up-right me-1"></i>
                            Ver cardápio
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <button
                            type="button"
                            class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="bi bi-person-circle me-1"></i>
                            {{ auth()->user()->name }}
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text">
                                    <small class="text-muted">
                                        {{ auth()->user()->email }}
                                    </small>
                                </span>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form
                                    action="{{ route('admin.logout') }}"
                                    method="POST"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="dropdown-item text-danger"
                                    >
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Sair
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>

        {{-- Menu lateral --}}
        <aside
            class="app-sidebar shadow"
            data-bs-theme="dark"
        >
            <div class="sidebar-brand">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="brand-link"
                >
                    <span class="brand-text">
                        <i class="bi bi-shop me-2"></i>
                        Zurix
                    </span>
                </a>
            </div>

            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul
                        class="nav sidebar-menu flex-column"
                        data-lte-toggle="treeview"
                        role="menu"
                        data-accordion="false"
                    >
                        <li class="nav-header">
                            GESTÃO
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            >
                                <i class="nav-icon bi bi-speedometer2"></i>

                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="#"
                                class="nav-link"
                            >
                                <i class="nav-icon bi bi-receipt"></i>

                                <p>
                                    Pedidos

                                    <span class="nav-badge badge text-bg-warning me-3">
                                        0
                                    </span>
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('admin.products.index') }}"
                                class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                            >
                                <i class="nav-icon bi bi-box-seam"></i>
                                <p>Produtos</p>
                            </a>
                        </li>

                        <li class="nav-item">
                        <a
                            href="{{ route('admin.categories.index') }}"
                            class="nav-link
                                {{ request()->routeIs(
                                    'admin.categories.*'
                                ) ? 'active' : '' }}"
                        >
                            <i class="nav-icon bi bi-tags"></i>

                            <p>Categorias</p>
                        </a>
                    </li>

                        <li class="nav-item">
                            <a
                                href="#"
                                class="nav-link"
                            >
                                <i class="nav-icon bi bi-people"></i>

                                <p>Clientes</p>
                            </a>
                        </li>

                      <li class="nav-item">
                        <a
                            href="{{ route('admin.business.edit') }}"
                            class="nav-link {{ request()->routeIs('admin.business.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon bi bi-gear"></i>

                            <p>Configurações</p>
                        </a>
                    </li>

                        <li class="nav-item">
                            <a
                                href="#"
                                class="nav-link"
                            >
                                <i class="nav-icon bi bi-truck"></i>

                                <p>Taxas de entrega</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="#"
                                class="nav-link"
                            >
                                <i class="nav-icon bi bi-person-gear"></i>

                                <p>Usuários</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        {{-- Conteúdo --}}
        <main class="app-main">

            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h1 class="mb-0">
                                @yield('page-title', 'Dashboard')
                            </h1>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">
                                        Início
                                    </a>
                                </li>

                                @hasSection('breadcrumb')
                                    @yield('breadcrumb')
                                @endif
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">

                    @if (session('success'))
                        <div
                            class="alert alert-success alert-dismissible fade show"
                            role="alert"
                        >
                            <i class="bi bi-check-circle me-2"></i>

                            {{ session('success') }}

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Fechar"
                            ></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            class="alert alert-danger alert-dismissible fade show"
                            role="alert"
                        >
                            <i class="bi bi-exclamation-circle me-2"></i>

                            {{ session('error') }}

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Fechar"
                            ></button>
                        </div>
                    @endif

                    @yield('content')

                </div>
            </div>
        </main>

        {{-- Rodapé --}}
        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">
                Cardápio digital
            </div>

            <strong>
                Zurix &copy; {{ date('Y') }}
            </strong>
        </footer>

    </div>

    @stack('scripts')
</body>
</html>