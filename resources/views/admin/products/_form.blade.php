@php
    $editing = isset($product);
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Não foi possível salvar o produto.</strong>

        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="row g-4">

    {{-- COLUNA PRINCIPAL --}}
    <div class="col-xl-8">


        {{-- Informações básicas --}}
        <div class="card content-card mb-4">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-box-seam me-2"></i>
                    Informações do produto
                </h3>
            </div>


            <div class="card-body">

                <div class="row g-3">


                    <div class="col-md-8">

                        <x-z-input
                            name="name"
                            label="Nome do produto"
                            :value="$product->name ?? null"
                            maxlength="150"
                            required
                            autofocus
                        />

                    </div>


                    <div class="col-md-4">

                        <x-z-input
                            name="sku"
                            label="SKU"
                            :value="$product->sku ?? null"
                            maxlength="50"
                            placeholder="Ex.: ACA500"
                            class="text-uppercase"
                            help="Código interno opcional e exclusivo dentro do estabelecimento."
                        />

                    </div>



                    <div class="col-12">

                        <x-z-select
                            name="category_id"
                            label="Categoria"
                            :value="$product->category_id ?? null"
                            required
                        >

                            <option value="">
                                Selecione uma categoria
                            </option>


                            @foreach ($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    @selected(
                                        old(
                                            'category_id',
                                            $product->category_id ?? null
                                        ) == $category->id
                                    )
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach


                        </x-z-select>


                        @if ($categories->isEmpty())

                            <div class="form-text text-danger">
                                Cadastre uma categoria ativa antes de criar produtos.
                            </div>

                        @endif


                    </div>




                    <div class="col-12">

                        <x-z-input
                            name="short_description"
                            label="Descrição curta"
                            :value="$product->short_description ?? null"
                            maxlength="255"
                            placeholder="Texto resumido exibido no cardápio"
                        />

                    </div>




                    <div class="col-12">

                        <x-z-textarea
                            name="description"
                            label="Descrição completa"
                            :value="$product->description ?? null"
                            rows="5"
                            maxlength="5000"
                            help="Apresente ingredientes, características e informações importantes."
                        />

                    </div>


                </div>

            </div>

        </div>






        {{-- Preços --}}
        <div class="card content-card mb-4">


            <div class="card-header">

                <h3 class="card-title">
                    <i class="bi bi-cash-coin me-2"></i>
                    Preços e preparo
                </h3>

            </div>



            <div class="card-body">


                <div class="row g-3">


                    <div class="col-md-4">

                        <x-z-money
                            name="price"
                            label="Preço normal"
                            :value="$product->price ?? null"
                            required
                        />

                    </div>



                    <div class="col-md-4">

                        <x-z-money
                            name="promotional_price"
                            label="Preço promocional"
                            :value="$product->promotional_price ?? null"
                        />

                    </div>




                    <div class="col-md-4">

                        <x-z-number
                            name="preparation_time"
                            label="Tempo de preparo"
                            :value="$product->preparation_time ?? null"
                            min="1"
                            max="1440"
                            help="Informe o tempo em minutos."
                        />

                    </div>



                </div>


            </div>


        </div>

        {{-- Imagens --}}
        <div class="card content-card mb-4">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-images me-2"></i>
                    Imagens do produto
                </h3>
            </div>

            <div class="card-body">
                <label for="images" class="form-label">
                    Adicionar imagens
                </label>

                <input
                    type="file"
                    name="images[]"
                    id="images"
                    multiple
                    accept=".jpg,.jpeg,.png,.webp"
                    class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                >

                <div class="form-text">
                    Envie até 10 imagens por vez. A primeira imagem do produto será definida como principal.
                </div>

                @error('images')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                @error('images.*')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                @if ($editing && $product->images->isNotEmpty())
                    <hr>

                    <h4 class="h6 mb-3">
                        Galeria atual
                    </h4>

                    <div class="row g-3">
                        @foreach ($product->images as $image)
                            <div class="col-md-4 col-lg-3">
                                <div class="card h-100">
                                    <img
                                        src="{{ asset('storage/'.$image->image_path) }}"
                                        alt="{{ $image->alt_text ?: $product->name }}"
                                        class="card-img-top"
                                        style="height: 150px; object-fit: cover;"
                                    >

                                    <div class="card-body p-2">
                                        @if ($image->is_primary)
                                            <span class="badge text-bg-primary mb-2">
                                                Principal
                                            </span>
                                        @endif

                                        <div class="d-grid gap-2">
                                            @unless ($image->is_primary)
                                                <button
                                                    type="submit"
                                                    form="primary-image-{{ $image->uuid }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                >
                                                    Tornar principal
                                                </button>
                                            @endunless

                                            <button
                                                type="submit"
                                                form="delete-image-{{ $image->uuid }}"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Excluir esta imagem?');"
                                            >
                                                Excluir
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>

    <div class="col-xl-4">

        {{-- Exibição --}}
        <div class="card content-card mb-4">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-sliders me-2"></i>
                    Exibição e disponibilidade
                </h3>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label for="sort_order" class="form-label">
                        Ordem de exibição
                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        id="sort_order"
                        min="0"
                        max="99999"
                        value="{{ old('sort_order', $product->sort_order ?? 0) }}"
                        class="form-control @error('sort_order') is-invalid @enderror"
                    >

                    @error('sort_order')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                @foreach ([
                    'is_active' => ['Produto ativo', true],
                    'is_available' => ['Disponível para venda', true],
                    'is_sold_out' => ['Produto esgotado', false],
                    'is_featured' => ['Produto em destaque', false],
                    'is_product_of_the_day' => ['Produto do dia', false],
                ] as $field => [$label, $default])
                    <div class="form-check form-switch mb-3">
                        <input
                            type="hidden"
                            name="{{ $field }}"
                            value="0"
                        >

                        <input
                            type="checkbox"
                            name="{{ $field }}"
                            id="{{ $field }}"
                            value="1"
                            class="form-check-input"
                            @checked(old($field, $product->{$field} ?? $default))
                        >

                        <label
                            for="{{ $field }}"
                            class="form-check-label"
                        >
                            {{ $label }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Resumo --}}
        @if ($editing)
            <div class="card content-card mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-info-circle me-2"></i>
                        Resumo
                    </h3>
                </div>

                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5">Identificador</dt>
                        <dd class="col-7">
                            <code>{{ $product->slug }}</code>
                        </dd>

                        <dt class="col-5">Preço atual</dt>
                        <dd class="col-7">
                            R$ {{ number_format($product->currentPrice(), 2, ',', '.') }}
                        </dd>

                        <dt class="col-5">Imagens</dt>
                        <dd class="col-7">
                            {{ $product->images->count() }}
                        </dd>

                        <dt class="col-5">Criado em</dt>
                        <dd class="col-7">
                            {{ $product->created_at?->format('d/m/Y H:i') }}
                        </dd>
                    </dl>
                </div>
            </div>
        @endif

        <div class="d-grid gap-2">
            <button
                type="submit"
                class="btn btn-primary btn-lg"
                @disabled($categories->isEmpty())
            >
                <i class="bi bi-check-circle me-2"></i>

                {{ $editing ? 'Salvar alterações' : 'Cadastrar produto' }}
            </button>

            <a
                href="{{ route('admin.products.index') }}"
                class="btn btn-outline-secondary"
            >
                Cancelar
            </a>
        </div>

    </div>
</div>