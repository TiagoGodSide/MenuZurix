<div class="product-card">


    <div class="product-image">

        @if ($product->image)

            <img 
                src="{{ asset('storage/'.$product->image->path) }}"
                alt="{{ $product->name }}"
            >

        @endif


        @if ($product->hasPromotion())

            <span class="promotion-badge">
                🔥 Promoção
            </span>

        @endif

    </div>



    <div class="product-content">


        <h3>
            {{ $product->name }}
        </h3>



        @if ($product->shortDescription)

            <p class="product-description">
                {{ $product->shortDescription }}
            </p>

        @endif



        <div class="product-footer">


            <div class="product-price">


                @if ($product->hasPromotion())

                    <span class="old-price">
                        R$
                        {{ number_format($product->price,2,',','.') }}
                    </span>


                    <strong>
                        R$
                        {{ number_format($product->promotionalPrice,2,',','.') }}
                    </strong>


                @else


                    <strong>
                        R$
                        {{ number_format($product->price,2,',','.') }}
                    </strong>


                @endif


            </div>



          <button 
            class="add-button"

            data-product-id="{{ $product->id }}"

            data-product-name="{{ $product->name }}"

            data-product-price="{{ $product->hasPromotion() ? $product->promotionalPrice : $product->price }}"
        >
            +
        </button>

        </div>


    </div>


</div>