@extends('layouts.admin')

@section('title', 'Editar grupo de opções')

@section('page-title', 'Editar grupo de opções')

@section('breadcrumb')

    <a
        href="{{ route('admin.option-groups.index') }}"
        class="text-decoration-none"
    >
        Grupos de opções
    </a>

    <span class="mx-1">/</span>

    Editar grupo

@endsection

@section('content')

    <form
        action="{{ route(
            'admin.option-groups.update',
            $optionGroup
        ) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        @include(
            'admin.option-groups._form',
            [
                'optionGroup' => $optionGroup,
            ]
        )

    </form>

@endsection