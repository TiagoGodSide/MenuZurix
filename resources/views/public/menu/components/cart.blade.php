<div id="cart-overlay"></div>
<div class="cart-panel" id="cart-panel">


    <div class="cart-header">

        <h2>
            🛒 Meu pedido
        </h2>

        <button id="close-cart">
            ×
        </button>

    </div>



    <div id="cart-items">

        <p>
            Seu pedido está vazio.
        </p>

    </div>



    <div class="cart-footer">

    <div class="cart-order-observation">

        <label for="order-observation">
            Observações do pedido
            <span>(opcional)</span>
        </label>

        <textarea
            id="order-observation"
            maxlength="500"
            rows="3"
            placeholder="Ex.: Entregar na portaria. Tocar a campainha. Troco para R$ 100."
        ></textarea>

        <div class="order-observation-counter">
            <span id="order-observation-count">0</span>/500
        </div>

    </div>

            <strong id="cart-total">
                Total: R$ 0,00
            </strong>

            <button type="button">
                Finalizar pedido
            </button>

        </div>

</div>