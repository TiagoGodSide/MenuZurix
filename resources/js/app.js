console.log('APP.JS CARREGOU');

import * as bootstrap from "bootstrap";
import "admin-lte/dist/js/adminlte.min.js";

window.bootstrap = bootstrap;


// ===============================
// CARRINHO DO MENU PÚBLICO
// ===============================

document.addEventListener('DOMContentLoaded', () => {


    const buttons = document.querySelectorAll('.add-button');

    console.log('BOTÕES:', document.querySelectorAll('.add-button').length);
    
    buttons.forEach(button => {


        button.addEventListener('click', () => {


            const product = {
                id: button.dataset.productId,
                name: button.dataset.productName,
                price: button.dataset.productPrice
            };


            console.log('Produto adicionado:', product);


        });


    });


});