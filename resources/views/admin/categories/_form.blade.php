@php
    $editing = isset($category);
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Não foi possível salvar.</strong>

        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-tag me-2"></i>
                    Dados da categoria
                </h3>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label
                        for="name"
                        class="form-label"
                    >
                        Nome
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        maxlength="100"
                        required
                        autofocus
                        value="{{ old('name', $category->name ?? '') }}"
                        class="form-control
                            @error('name') is-invalid @enderror"
                    >

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label
                        for="description"
                        class="form-label"
                    >
                        Descrição
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="4"
                        maxlength="500"
                        class="form-control
                            @error('description') is-invalid @enderror"
                    >{{ old('description', $category->description ?? '') }}</textarea>

                    <div class="form-text">
                        Uma breve descrição exibida no cardápio.
                    </div>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label
                        for="banner_image"
                        class="form-label"
                    >
                        Banner da categoria
                    </label>

                    <input
                        type="file"
                        name="banner_image"
                        id="banner_image"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="form-control
                            @error('banner_image') is-invalid @enderror"
                    >

                    <div class="form-text">
                        JPG, PNG ou WebP. Máximo de 3 MB.
                    </div>

                    @error('banner_image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    @if (
                        $editing
                        && $category->banner_image
                    )
                        <div class="mt-3">
                            <img
                                src="{{ asset(
                                    'storage/'.
                                    $category->banner_image
                                ) }}"
                                alt="{{ $category->name }}"
                                class="img-fluid rounded border"
                                style="max-height: 220px;"
                            >
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-sliders me-2"></i>
                    Exibição
                </h3>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label
                        for="icon"
                        class="form-label"
                    >
                        Ícone
                    </label>

                    <input
                        type="text"
                        name="icon"
                        id="icon"
                        maxlength="80"
                        placeholder="bi bi-cup-straw"
                        value="{{ old(
                            'icon',
                            $category->icon ?? 'bi bi-tag'
                        ) }}"
                        class="form-control
                            @error('icon') is-invalid @enderror"
                    >

                    <div class="form-text">
                        Classe de um ícone do Bootstrap Icons.
                    </div>

                    @error('icon')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label
                        for="color"
                        class="form-label"
                    >
                        Cor
                    </label>

                    <input
                        type="color"
                        name="color"
                        id="color"
                        value="{{ old(
                            'color',
                            $category->color ?? '#0d6efd'
                        ) }}"
                        class="form-control form-control-color
                            @error('color') is-invalid @enderror"
                    >

                    @error('color')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label
                        for="sort_order"
                        class="form-label"
                    >
                        Ordem de exibição
                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        id="sort_order"
                        min="0"
                        max="9999"
                        value="{{ old(
                            'sort_order',
                            $category->sort_order ?? 0
                        ) }}"
                        class="form-control
                            @error('sort_order') is-invalid @enderror"
                    >

                    @error('sort_order')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-check form-switch">
                    <input
                        type="hidden"
                        name="is_active"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        name="is_active"
                        id="is_active"
                        value="1"
                        class="form-check-input"
                        @checked(
                            old(
                                'is_active',
                                $category->is_active ?? true
                            )
                        )
                    >

                    <label
                        for="is_active"
                        class="form-check-label"
                    >
                        Categoria ativa
                    </label>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 mt-3">
            <button
                type="submit"
                class="btn btn-primary"
            >
                <i class="bi bi-check-circle me-2"></i>

                {{ $editing
                    ? 'Salvar alterações'
                    : 'Cadastrar categoria'
                }}
            </button>

            <a
                href="{{ route(
                    'admin.categories.index'
                ) }}"
                class="btn btn-outline-secondary"
            >
                Cancelar
            </a>
        </div>
    </div>
</div>