<div class="menu-header">

    @if($menu->banner)

        <div class="menu-banner">
            <img 
                src="{{ asset('storage/'.$menu->banner) }}"
                alt="{{ $menu->name }}"
            >
        </div>

    @endif


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


          <button class="cart-placeholder" id="open-cart">
            🛒 Meu pedido
        </button>


        </div>


    </div>


</div>

 

