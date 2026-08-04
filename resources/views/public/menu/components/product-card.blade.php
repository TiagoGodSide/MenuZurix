<div style="margin-bottom:20px">

    @if ($product->image)
        <img
            src="{{ asset('storage/'.$product->image->path) }}"
            width="120"
        >
    @endif


    <strong>
        {{ $product->name }}
    </strong>


    @if ($product->shortDescription)
        <p>
            {{ $product->shortDescription }}
        </p>
    @endif


 @if ($product->hasPromotion())

    <p>
        <s>
            R$
            {{ number_format($product->price, 2, ',', '.') }}
        </s>
    </p>

    <strong>
        R$
        {{ number_format($product->promotionalPrice, 2, ',', '.') }}
    </strong>

@else

    <p>
        R$
        {{ number_format($product->price, 2, ',', '.') }}
    </p>

@endif

</div>