@extends('layouts.admin')

@section('title', 'Novo produto')
@section('page-title', 'Novo produto')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.products.index') }}">
            Produtos
        </a>
    </li>

    <li class="breadcrumb-item active">
        Novo
    </li>
@endsection

@section('content')
    <form
        action="{{ route('admin.products.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        @include('admin.products._form')
    </form>
@endsection