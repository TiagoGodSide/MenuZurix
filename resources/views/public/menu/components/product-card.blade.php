<div class="product-card">


    @if ($product->image)

        <div class="product-image">

            <img
                src="{{ asset('storage/'.$product->image->path) }}"
                alt="{{ $product->name }}"
            >

        </div>

    @endif



    <div class="product-content">


        <h3>
            {{ $product->name }}
        </h3>



        @if ($product->shortDescription)

            <p class="product-description">
                {{ $product->shortDescription }}
            </p>

        @endif




        <div class="product-price">


            @if ($product->hasPromotion())


                <span class="old-price">

                    R$
                    {{ number_format($product->price, 2, ',', '.') }}

                </span>


                <strong class="promo-price">

                    R$
                    {{ number_format($product->promotionalPrice, 2, ',', '.') }}

                </strong>


            @else


                <strong>

                    R$
                    {{ number_format($product->price, 2, ',', '.') }}

                </strong>


            @endif


        </div>


    </div>


</div>