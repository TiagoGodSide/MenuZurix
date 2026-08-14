@extends('layouts.admin')

@section('title', 'Novo grupo de opções')

@section('page-title', 'Novo grupo de opções')

@section('breadcrumb')

    <a
        href="{{ route('admin.option-groups.index') }}"
        class="text-decoration-none"
    >
        Grupos de opções
    </a>

    <span class="mx-1">/</span>

    Novo grupo

@endsection

@section('content')

    <form
        action="{{ route('admin.option-groups.store') }}"
        method="POST"
    >

        @csrf

        @include(
            'admin.option-groups._form'
        )

    </form>

@endsection