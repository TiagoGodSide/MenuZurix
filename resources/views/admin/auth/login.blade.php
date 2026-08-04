<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Entrar | Zurix</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

    <main class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-4 col-md-6">

                <div class="text-center mb-4">
                    <h1 class="h3 mb-1">Zurix</h1>

                    <p class="text-muted mb-0">
                        Painel administrativo
                    </p>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <h2 class="h5 mb-4">
                            Acessar o painel
                        </h2>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                Verifique os dados informados.
                            </div>
                        @endif

                        <form
                            action="{{ route('admin.login.store') }}"
                            method="POST"
                        >
                            @csrf

                            <div class="mb-3">
                                <label
                                    for="email"
                                    class="form-label"
                                >
                                    E-mail
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    autocomplete="email"
                                    autofocus
                                    required
                                >

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label
                                    for="password"
                                    class="form-label"
                                >
                                    Senha
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="current-password"
                                    required
                                >

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-check mb-4">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    value="1"
                                    class="form-check-input"
                                >

                                <label
                                    for="remember"
                                    class="form-check-label"
                                >
                                    Permanecer conectado
                                </label>
                            </div>

                            <button
                                type="submit"
                                class="btn btn-dark w-100"
                            >
                                Entrar
                            </button>
                        </form>

                    </div>
                </div>

                <div class="text-center mt-3">
                    <a
                        href="{{ route('site.home') }}"
                        class="text-decoration-none"
                    >
                        Voltar ao cardápio
                    </a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>