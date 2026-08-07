
import * as bootstrap from "bootstrap";
import "admin-lte/dist/js/adminlte.min.js";

window.bootstrap = bootstrap;


// ===============================
// CARRINHO DO MENU PÚBLICO
// ===============================

document.addEventListener('DOMContentLoaded', () => {

    const buttons = document.querySelectorAll('.add-button');


    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    updateCartCount();

    buttons.forEach(button => {


        button.addEventListener('click', () => {


            const product = {

                id: Number(button.dataset.productId),

                name: button.dataset.productName,

                price: Number(button.dataset.productPrice)

            };


            const existingProduct = cart.find(
                item => item.id === product.id
            );


            if (existingProduct) {

                existingProduct.quantity++;

            } else {

                cart.push({

                    ...product,

                    quantity: 1

                });

            }


            localStorage.setItem(
                'cart',
                JSON.stringify(cart)
            );

            updateCartCount();

            console.log('Carrinho:', cart);


        });


    });


});

const openCartButton = document.getElementById('open-cart');
const closeCartButton = document.getElementById('close-cart');
const cartPanel = document.getElementById('cart-panel');


if (openCartButton) {

    openCartButton.addEventListener('click', () => {

        renderCart();

        cartPanel.classList.add('active');

    });

}


if (closeCartButton) {

    closeCartButton.addEventListener('click', () => {

        cartPanel.classList.remove('active');

    });

}

function updateCartCount() {

    const cartCount = document.getElementById('cart-count');

    if (!cartCount) {
        return;
    }

    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    const totalItems = cart.reduce(
        (total, item) => total + item.quantity,
        0
    );


    if (totalItems > 0) {

        cartCount.innerHTML = totalItems;

    } else {

        cartCount.innerHTML = '';

    }

}


// ===============================
// RENDERIZAR CARRINHO
// ===============================

function renderCart() {

    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.querySelector('.cart-footer strong');


    if (!cartItems || !cartTotal) {
        return;
    }
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (cart.length === 0) {

        cartItems.innerHTML = `
            <p>
                Seu pedido está vazio.
            </p>
        `;

        cartTotal.innerHTML = `
            Total: R$ 0,00
        `;

        return;
    }

    let total = 0;

    cartItems.innerHTML = cart.map(item => {

        total += item.price * item.quantity;

        return `

<div class="cart-item">


    <div class="cart-item-info">

        <strong class="cart-item-name">
            ${item.name}
        </strong>

        <span class="cart-item-price">
            R$ ${(item.price * item.quantity).toFixed(2)}
        </span>

    </div>



    <div class="cart-item-actions">


        <button 
            class="decrease-button"
            data-id="${item.id}">
            -
        </button>


        <span class="cart-quantity">
            ${item.quantity}
        </span>


        <button 
            class="increase-button"
            data-id="${item.id}">
            +
        </button>


        <button 
            class="remove-button"
            data-id="${item.id}">
            🗑
        </button>


    </div>


</div>

`;

    }).join('');

    cartTotal.innerHTML = `
        Total: R$ ${total.toFixed(2)}
    `;

}