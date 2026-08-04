@extends('public.menu.layouts.menu')


@section('content')


@include(
    'public.menu.components.header',
    ['menu' => $menu]
)


<hr>


@foreach ($menu->categories as $category)

    @include(
        'public.menu.components.category',
        ['category' => $category]
    )

@endforeach


@endsection