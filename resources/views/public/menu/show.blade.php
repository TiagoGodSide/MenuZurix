@extends('public.menu.layouts.menu')


@section('content')


@include(
    'public.menu.components.header',
    ['menu' => $menu]
)

@include(
'public.menu.components.cart'
)


<div class="category-sticky">

    <nav class="category-menu">

        @foreach($menu->categories as $category)

            <a href="#categoria-{{ Str::slug($category->name) }}">
                {{ $category->name }}
            </a>

        @endforeach

    </nav>

</div>
<hr>


@foreach ($menu->categories as $category)

    @include(
        'public.menu.components.category',
        ['category' => $category]
    )

@endforeach


@endsection