@extends('layouts.admin')

@section('title', 'Nova categoria')
@section('page-title', 'Nova categoria')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.categories.index') }}">
            Categorias
        </a>
    </li>

    <li class="breadcrumb-item active">
        Nova
    </li>
@endsection

@section('content')
    <form
        action="{{ route('admin.categories.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        @include('admin.categories._form')
    </form>
@endsection