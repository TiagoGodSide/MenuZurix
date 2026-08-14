@php
    $editing = isset($optionItem);
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

    {{-- Informações do item --}}
    <div class="col-lg-8">

        <div class="card content-card">

            <div class="card-header">
                <h3 class="card-title mb-0">
                    <i class="bi bi-list-check me-2"></i>
                    Informações do item
                </h3>
            </div>

            <div class="card-body">

                <div class="mb-3">

                    <label
                        for="name"
                        class="form-label"
                    >
                        Nome do item
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
                            $optionItem->name ?? ''
                        ) }}"
                        placeholder="Ex.: Banana"
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
                        placeholder="Ex.: Banana em rodelas."
                        class="form-control
                            @error('description') is-invalid @enderror"
                    >{{ old(
                        'description',
                        $optionItem->description ?? ''
                    ) }}</textarea>

                    <div class="form-text">
                        Uma breve descrição exibida ao cliente.
                    </div>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-0">

                    <label
                        for="additional_price"
                        class="form-label"
                    >
                        Preço adicional
                        <span class="text-danger">*</span>
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            R$
                        </span>

                        <input
                            type="number"
                            name="additional_price"
                            id="additional_price"
                            min="0"
                            max="99999999.99"
                            step="0.01"
                            required
                            value="{{ old(
                                'additional_price',
                                isset($optionItem)
                                    ? number_format(
                                        (float) $optionItem->additional_price,
                                        2,
                                        '.',
                                        ''
                                    )
                                    : '0.00'
                            ) }}"
                            class="form-control
                                @error('additional_price') is-invalid @enderror"
                        >

                        @error('additional_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="form-text">
                        Informe 0,00 quando o item não tiver custo adicional.
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Configurações --}}
    <div class="col-lg-4">

        <div class="card content-card">

            <div class="card-header">
                <h3 class="card-title mb-0">
                    <i class="bi bi-sliders me-2"></i>
                    Configurações
                </h3>
            </div>

            <div class="card-body">

                <div class="mb-3">

                    <label
                        for="max_quantity"
                        class="form-label"
                    >
                        Quantidade máxima
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="number"
                        name="max_quantity"
                        id="max_quantity"
                        min="1"
                        max="999"
                        required
                        value="{{ old(
                            'max_quantity',
                            $optionItem->max_quantity ?? 1
                        ) }}"
                        class="form-control
                            @error('max_quantity') is-invalid @enderror"
                    >

                    <div class="form-text">
                        Quantas unidades deste item o cliente poderá adicionar.
                    </div>

                    @error('max_quantity')
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
                        max="999999"
                        value="{{ old(
                            'sort_order',
                            $optionItem->sort_order ?? 0
                        ) }}"
                        class="form-control
                            @error('sort_order') is-invalid @enderror"
                    >

                    <div class="form-text">
                        Itens com menor número aparecem primeiro.
                    </div>

                    @error('sort_order')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="form-check form-switch mb-3">

                    <input
                        type="hidden"
                        name="is_default"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        name="is_default"
                        id="is_default"
                        value="1"
                        class="form-check-input"
                        @checked(
                            old(
                                'is_default',
                                $optionItem->is_default ?? false
                            )
                        )
                    >

                    <label
                        for="is_default"
                        class="form-check-label"
                    >
                        Item padrão
                    </label>

                    <div class="form-text">
                        Define este item como selecionado por padrão.
                    </div>

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
                                $optionItem->is_active ?? true
                            )
                        )
                    >

                    <label
                        for="is_active"
                        class="form-check-label"
                    >
                        Item ativo
                    </label>

                    <div class="form-text">
                        Itens inativos não ficam disponíveis no cardápio.
                    </div>

                </div>

            </div>

        </div>


        {{-- Ações --}}
        <div class="d-grid gap-2 mt-3">

            <button
                type="submit"
                class="btn btn-primary"
            >
                <i class="bi bi-check-circle me-2"></i>

                {{ $editing
                    ? 'Salvar alterações'
                    : 'Cadastrar item'
                }}
            </button>

            <a
                href="{{ route(
                    'admin.option-groups.items.index',
                    $optionGroup
                ) }}"
                class="btn btn-outline-secondary"
            >
                Cancelar
            </a>

        </div>

    </div>

</div>