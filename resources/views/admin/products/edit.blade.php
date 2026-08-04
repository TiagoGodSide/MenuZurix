@extends('layouts.admin')

@section('title', 'Editar produto')
@section('page-title', 'Editar produto')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.products.index') }}">
            Produtos
        </a>
    </li>

    <li class="breadcrumb-item active">
        Editar
    </li>
@endsection

@section('content')
    <form
        action="{{ route('admin.products.update', $product) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        @include('admin.products._form')
    </form>

    @foreach ($product->images as $image)
        <form
            id="primary-image-{{ $image->uuid }}"
            action="{{ route('admin.products.images.primary', [$product, $image]) }}"
            method="POST"
            class="d-none"
        >
            @csrf
            @method('PATCH')
        </form>

        <form
            id="delete-image-{{ $image->uuid }}"
            action="{{ route('admin.products.images.destroy', [$product, $image]) }}"
            method="POST"
            class="d-none"
        >
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endsection