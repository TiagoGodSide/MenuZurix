@extends('layouts.admin')

@section('title', 'Editar categoria')
@section('page-title', 'Editar categoria')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.categories.index') }}">
            Categorias
        </a>
    </li>

    <li class="breadcrumb-item active">
        Editar
    </li>
@endsection

@section('content')
    <form
        action="{{ route(
            'admin.categories.update',
            $category
        ) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        @include('admin.categories._form')
    </form>
@endsection