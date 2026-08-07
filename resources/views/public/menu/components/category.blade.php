<section class="category"
id="categoria-{{ Str::slug($category->name) }}">

    <h2>
        {{ $category->name }}
    </h2>


    <div class="products-grid">


        @foreach($category->products as $product)

            @include('public.menu.components.product-card')

        @endforeach


    </div>


</section>