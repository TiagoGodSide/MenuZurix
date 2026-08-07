
import * as bootstrap from "bootstrap";
import "admin-lte/dist/js/adminlte.min.js";

window.bootstrap = bootstrap;


            // ===============================
// CARRINHO DO MENU PÚBLICO
// ===============================

document.addEventListener('DOMContentLoaded', () => {

    const buttons = document.querySelectorAll('.add-button');


    let cart = JSON.parse(localStorage.getItem('cart')) || [];


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


            if(existingProduct){

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


            console.log('Carrinho:', cart);


        });


    });


});
