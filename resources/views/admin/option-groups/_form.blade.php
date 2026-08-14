@php
    $editing = isset($optionGroup);
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

<div class="row g-4">

    <div class="col-lg-8">

        <div class="card content-card">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-list-check me-2"></i>
                    Informações do grupo
                </h3>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label
                        for="name"
                        class="form-label"
                    >
                        Nome do grupo
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        maxlength="120"
                        required
                        autofocus
                        value="{{ old(
                            'name',
                            $optionGroup->name ?? ''
                        ) }}"
                        placeholder="Ex.: Adicionais"
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
                        maxlength="255"
                        class="form-control
                            @error('description') is-invalid @enderror"
                        placeholder="Ex.: Escolha os adicionais para o seu pedido."
                    >{{ old(
                        'description',
                        $optionGroup->description ?? ''
                    ) }}</textarea>

                    <div class="form-text">
                        Uma breve orientação para o cliente sobre este grupo.
                    </div>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

        </div>

        <div class="card content-card mt-4">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-ui-checks me-2"></i>
                    Tipo de escolha
                </h3>
            </div>

            <div class="card-body">

                <div class="form-check mb-3">

                    <input
                        class="form-check-input"
                        type="radio"
                        name="selection_type"
                        id="selection_type_single"
                        value="single"
                        @checked(
                            old(
                                'selection_type',
                                $optionGroup->selection_type ?? 'multiple'
                            ) === 'single'
                        )
                    >

                    <label
                        class="form-check-label"
                        for="selection_type_single"
                    >
                        <strong>Escolha única</strong>

                        <div class="small text-muted">
                            O cliente poderá escolher apenas uma opção.
                        </div>
                    </label>

                </div>

                <div class="form-check">

                    <input
                        class="form-check-input"
                        type="radio"
                        name="selection_type"
                        id="selection_type_multiple"
                        value="multiple"
                        @checked(
                            old(
                                'selection_type',
                                $optionGroup->selection_type ?? 'multiple'
                            ) === 'multiple'
                        )
                    >

                    <label
                        class="form-check-label"
                        for="selection_type_multiple"
                    >
                        <strong>Escolha múltipla</strong>

                        <div class="small text-muted">
                            O cliente poderá escolher mais de uma opção.
                        </div>
                    </label>

                </div>

                @error('selection_type')
                    <div class="text-danger small mt-2">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card content-card">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-sliders me-2"></i>
                    Configurações
                </h3>
            </div>

            <div class="card-body">

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
                                $optionGroup->is_active ?? true
                            )
                        )
                    >

                    <label
                        for="is_active"
                        class="form-check-label"
                    >
                        Grupo ativo
                    </label>

                </div>

                <div class="form-text mt-2">
                    Grupos inativos não ficam disponíveis para utilização
                    no cardápio.
                </div>

            </div>

        </div>

        <div class="card content-card mt-4">

            <div class="card-body">

                <div class="d-grid gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-check-circle me-2"></i>

                        {{ $editing
                            ? 'Salvar alterações'
                            : 'Cadastrar grupo'
                        }}
                    </button>

                    <a
                        href="{{ route(
                            'admin.option-groups.index'
                        ) }}"
                        class="btn btn-outline-secondary"
                    >
                        Cancelar
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>