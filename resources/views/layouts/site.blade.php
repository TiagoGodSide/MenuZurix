<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>@yield('title', 'Cardápio') | Zurix</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">
    <header class="bg-dark text-white py-3">
        <div class="container">
            <a
                href="{{ route('site.home') }}"
                class="text-white text-decoration-none"
            >
                <strong>Zurix</strong>
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>

    @stack('scripts')
</body>
</html>