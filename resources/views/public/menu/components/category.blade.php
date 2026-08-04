<div>

    <h2>
        {{ $category->name }}
    </h2>


    @foreach ($category->products as $product)

        @include(
            'public.menu.components.product-card',
            ['product' => $product]
        )

    @endforeach

</div>