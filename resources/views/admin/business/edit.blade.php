@extends('layouts.admin')

@section('title', 'Configurações do negócio')
@section('page-title', 'Configurações do negócio')

@section('breadcrumb')
    <li class="breadcrumb-item active">
        Negócio
    </li>
@endsection

@section('content')

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

    <form
        action="{{ route('admin.business.update') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xl-8">

                {{-- Dados gerais --}}
                <div class="card content-card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-shop me-2"></i>
                            Dados gerais
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="name" class="form-label">
                                    Nome do negócio
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name', $business->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    maxlength="150"
                                    required
                                >

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="business_type" class="form-label">
                                    Tipo de negócio
                                </label>

                                <select
                                    name="business_type"
                                    id="business_type"
                                    class="form-select @error('business_type') is-invalid @enderror"
                                    required
                                >
                                    @foreach ($businessTypes as $type)
                                        <option
                                            value="{{ $type->value }}"
                                            @selected(
                                                old(
                                                    'business_type',
                                                    $business->business_type->value
                                                ) === $type->value
                                            )
                                        >
                                            {{ $type->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="legal_name" class="form-label">
                                    Razão social
                                </label>

                                <input
                                    type="text"
                                    name="legal_name"
                                    id="legal_name"
                                    value="{{ old('legal_name', $business->legal_name) }}"
                                    class="form-control"
                                    maxlength="180"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Imagens --}}
                <div class="card content-card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-images me-2"></i>
                            Identidade visual
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-5">
                                <label for="logo" class="form-label">
                                    Logotipo
                                </label>

                                <input
                                    type="file"
                                    name="logo"
                                    id="logo"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="form-control"
                                >

                                <div class="form-text">
                                    JPG, PNG ou WebP. Máximo de 2 MB.
                                </div>

                                @if ($business->logo_path)
                                    <img
                                        src="{{ asset('storage/'.$business->logo_path) }}"
                                        alt="{{ $business->name }}"
                                        class="img-thumbnail mt-3"
                                        style="max-height: 140px;"
                                    >
                                @endif
                            </div>

                            <div class="col-md-7">
                                <label for="banner" class="form-label">
                                    Banner
                                </label>

                                <input
                                    type="file"
                                    name="banner"
                                    id="banner"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="form-control"
                                >

                                <div class="form-text">
                                    JPG, PNG ou WebP. Máximo de 4 MB.
                                </div>

                                @if ($business->banner_path)
                                    <img
                                        src="{{ asset('storage/'.$business->banner_path) }}"
                                        alt="Banner de {{ $business->name }}"
                                        class="img-fluid rounded border mt-3"
                                        style="max-height: 220px;"
                                    >
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label for="primary_color" class="form-label">
                                    Cor principal
                                </label>

                                <input
                                    type="color"
                                    name="primary_color"
                                    id="primary_color"
                                    value="{{ old('primary_color', $business->primary_color) }}"
                                    class="form-control form-control-color"
                                >
                            </div>

                            <div class="col-md-4">
                                <label for="secondary_color" class="form-label">
                                    Cor secundária
                                </label>

                                <input
                                    type="color"
                                    name="secondary_color"
                                    id="secondary_color"
                                    value="{{ old('secondary_color', $business->secondary_color) }}"
                                    class="form-control form-control-color"
                                >
                            </div>

                            <div class="col-md-4">
                                <label for="theme" class="form-label">
                                    Tema
                                </label>

                                <select
                                    name="theme"
                                    id="theme"
                                    class="form-select"
                                >
                                    <option
                                        value="light"
                                        @selected(old('theme', $business->theme) === 'light')
                                    >
                                        Claro
                                    </option>

                                    <option
                                        value="dark"
                                        @selected(old('theme', $business->theme) === 'dark')
                                    >
                                        Escuro
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contatos --}}
                <div class="card content-card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-telephone me-2"></i>
                            Contatos e redes sociais
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    E-mail
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email', $business->email) }}"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-md-3">
                                <label for="phone" class="form-label">
                                    Telefone
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    id="phone"
                                    value="{{ old('phone', $business->phone) }}"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-md-3">
                                <label for="whatsapp" class="form-label">
                                    WhatsApp
                                </label>

                                <input
                                    type="text"
                                    name="whatsapp"
                                    id="whatsapp"
                                    value="{{ old('whatsapp', $business->whatsapp) }}"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-md-6">
                                <label for="instagram" class="form-label">
                                    Instagram
                                </label>

                                <input
                                    type="text"
                                    name="instagram"
                                    id="instagram"
                                    value="{{ old('instagram', $business->instagram) }}"
                                    class="form-control"
                                    placeholder="@nomedaloja"
                                >
                            </div>

                            <div class="col-md-6">
                                <label for="facebook" class="form-label">
                                    Facebook
                                </label>

                                <input
                                    type="text"
                                    name="facebook"
                                    id="facebook"
                                    value="{{ old('facebook', $business->facebook) }}"
                                    class="form-control"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Endereço --}}
                <div class="card content-card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-geo-alt me-2"></i>
                            Endereço
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="zip_code" class="form-label">
                                    CEP
                                </label>

                                <input
                                    type="text"
                                    name="zip_code"
                                    id="zip_code"
                                    value="{{ old('zip_code', $business->zip_code) }}"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-md-7">
                                <label for="street" class="form-label">
                                    Rua
                                </label>

                                <input
                                    type="text"
                                    name="street"
                                    id="street"
                                    value="{{ old('street', $business->street) }}"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-md-2">
                                <label for="number" class="form-label">
                                    Número
                                </label>

                                <input
                                    type="text"
                                    name="number"
                                    id="number"
                                    value="{{ old('number', $business->number) }}"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-md-6">
                                <label for="complement" class="form-label">
                                    Complemento
                                </label>

                                <input
                                    type="text"
                                    name="complement"
                                    id="complement"
                                    value="{{ old('complement', $business->complement) }}"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-md-6">
                                <label for="neighborhood" class="form-label">
                                    Bairro
                                </label>

                                <input
                                    type="text"
                                    name="neighborhood"
                                    id="neighborhood"
                                    value="{{ old('neighborhood', $business->neighborhood) }}"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-md-9">
                                <label for="city" class="form-label">
                                    Cidade
                                </label>

                                <input
                                    type="text"
                                    name="city"
                                    id="city"
                                    value="{{ old('city', $business->city) }}"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-md-3">
                                <label for="state" class="form-label">
                                    Estado
                                </label>

                                <input
                                    type="text"
                                    name="state"
                                    id="state"
                                    maxlength="2"
                                    value="{{ old('state', $business->state) }}"
                                    class="form-control text-uppercase"
                                >
                            </div>

                            <div class="col-md-6">
                                <label for="latitude" class="form-label">
                                    Latitude
                                </label>

                                <input
                                    type="number"
                                    step="0.0000001"
                                    name="latitude"
                                    id="latitude"
                                    value="{{ old('latitude', $business->latitude) }}"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-md-6">
                                <label for="longitude" class="form-label">
                                    Longitude
                                </label>

                                <input
                                    type="number"
                                    step="0.0000001"
                                    name="longitude"
                                    id="longitude"
                                    value="{{ old('longitude', $business->longitude) }}"
                                    class="form-control"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pagamento --}}
                <div class="card content-card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-qr-code me-2"></i>
                            PIX
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="pix_key_type" class="form-label">
                                    Tipo da chave
                                </label>

                                <select
                                    name="pix_key_type"
                                    id="pix_key_type"
                                    class="form-select"
                                >
                                    <option value="">
                                        Não configurado
                                    </option>

                                    @foreach ([
                                        'cpf' => 'CPF',
                                        'cnpj' => 'CNPJ',
                                        'email' => 'E-mail',
                                        'phone' => 'Telefone',
                                        'random' => 'Chave aleatória',
                                    ] as $value => $label)
                                        <option
                                            value="{{ $value }}"
                                            @selected(
                                                old(
                                                    'pix_key_type',
                                                    $business->pix_key_type
                                                ) === $value
                                            )
                                        >
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-8">
                                <label for="pix_key" class="form-label">
                                    Chave PIX
                                </label>

                                <input
                                    type="text"
                                    name="pix_key"
                                    id="pix_key"
                                    value="{{ old('pix_key', $business->pix_key) }}"
                                    class="form-control"
                                >
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-4">

                {{-- Operação --}}
                <div class="card content-card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-sliders me-2"></i>
                            Operação
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">
                                Status atual
                            </label>

                            <select
                                name="status"
                                id="status"
                                class="form-select"
                            >
                                @foreach ($businessStatuses as $status)
                                    <option
                                        value="{{ $status->value }}"
                                        @selected(
                                            old(
                                                'status',
                                                $business->status->value
                                            ) === $status->value
                                        )
                                    >
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="minimum_order" class="form-label">
                                Pedido mínimo
                            </label>

                            <input
                                type="number"
                                name="minimum_order"
                                id="minimum_order"
                                min="0"
                                step="0.01"
                                value="{{ old('minimum_order', $business->minimum_order) }}"
                                class="form-control"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="default_delivery_fee" class="form-label">
                                Taxa padrão de entrega
                            </label>

                            <input
                                type="number"
                                name="default_delivery_fee"
                                id="default_delivery_fee"
                                min="0"
                                step="0.01"
                                value="{{ old('default_delivery_fee', $business->default_delivery_fee) }}"
                                class="form-control"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="average_preparation_time" class="form-label">
                                Tempo médio de preparo
                            </label>

                            <div class="input-group">
                                <input
                                    type="number"
                                    name="average_preparation_time"
                                    id="average_preparation_time"
                                    min="1"
                                    value="{{ old(
                                        'average_preparation_time',
                                        $business->average_preparation_time
                                    ) }}"
                                    class="form-control"
                                >

                                <span class="input-group-text">
                                    minutos
                                </span>
                            </div>
                        </div>

                        @foreach ([
                            'accepts_orders' => 'Receber pedidos',
                            'accepts_delivery' => 'Aceitar entrega',
                            'accepts_pickup' => 'Aceitar retirada',
                        ] as $field => $label)
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
                                    @checked(old($field, $business->{$field}))
                                >

                                <label
                                    for="{{ $field }}"
                                    class="form-check-label"
                                >
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach

                        <div class="mb-0">
                            <label for="timezone" class="form-label">
                                Fuso horário
                            </label>

                            <input
                                type="text"
                                name="timezone"
                                id="timezone"
                                value="{{ old('timezone', $business->timezone) }}"
                                class="form-control"
                            >
                        </div>
                    </div>
                </div>

                {{-- Mensagens --}}
                <div class="card content-card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-chat-left-text me-2"></i>
                            Mensagens automáticas
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="closed_message" class="form-label">
                                Loja fechada
                            </label>

                            <textarea
                                name="closed_message"
                                id="closed_message"
                                rows="3"
                                maxlength="1000"
                                class="form-control"
                            >{{ old('closed_message', $business->closed_message) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="paused_message" class="form-label">
                                Loja pausada
                            </label>

                            <textarea
                                name="paused_message"
                                id="paused_message"
                                rows="3"
                                maxlength="1000"
                                class="form-control"
                            >{{ old('paused_message', $business->paused_message) }}</textarea>
                        </div>

                        <div>
                            <label for="vacation_message" class="form-label">
                                Férias
                            </label>

                            <textarea
                                name="vacation_message"
                                id="vacation_message"
                                rows="3"
                                maxlength="1000"
                                class="form-control"
                            >{{ old('vacation_message', $business->vacation_message) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button
                        type="submit"
                        class="btn btn-primary btn-lg"
                    >
                        <i class="bi bi-check-circle me-2"></i>
                        Salvar configurações
                    </button>

                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="btn btn-outline-secondary"
                    >
                        Cancelar
                    </a>
                </div>

            </div>
        </div>
    </form>

@endsection