<div class="menu-header">


    {{-- BANNER --}}
    @if($menu->banner)

        <div class="menu-banner">
            <img 
                src="{{ asset('storage/'.$menu->banner) }}"
                alt="{{ $menu->name }}"
            >
        </div>

    @endif



    {{-- INFORMAÇÕES DO RESTAURANTE --}}
    <div class="menu-info">


        <div class="menu-brand">


          @if($menu->logo)

            <img
                src="{{ asset('storage/'.$menu->logo) }}"
                alt="{{ $menu->name }}"
                class="menu-logo"
            >

@endif
            <h1>
                {{ $menu->name }}
            </h1>


        </div>



        <div class="menu-actions">


            <span class="{{ $menu->isOpen ? 'open' : 'closed' }}">

                {{ $menu->isOpen 
                    ? '🟢 Aberto para pedidos'
                    : '🔴 Fechado'
                }}

            </span>


            <span class="cart-placeholder">
                🛒 Meu pedido
            </span>


        </div>


    </div>


</div>