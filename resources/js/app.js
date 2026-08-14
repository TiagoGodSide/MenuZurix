
import * as bootstrap from "bootstrap";
import "admin-lte/dist/js/adminlte.min.js";

window.bootstrap = bootstrap;


// ===============================
// CARRINHO DO MENU PÚBLICO
// ===============================

document.addEventListener('DOMContentLoaded', () => {

    const buttons = document.querySelectorAll('.add-button');

    updateCartCount();

    buttons.forEach(button => {

        button.addEventListener('click', () => {

            const product = {

                id: Number(button.dataset.productId),

                name: button.dataset.productName,

                price: Number(button.dataset.productPrice)

            };

            let optionGroups = [];

            try {

                optionGroups = JSON.parse(
                    button.dataset.optionGroups || '[]'
                );

            } catch (error) {

                console.error(
                    'Erro ao carregar opções do produto:',
                    error
                );

                optionGroups = [];

            }

           openProductOptionsModal(
                product,
                optionGroups
            );

        });

    });

});



function addProductToCart(
    product,
    options = [],
    observation = ''
) {

    let cart = JSON.parse(
        localStorage.getItem('cart')
    ) || [];


    observation =
        String(observation || '').trim();


    const optionsPrice = options.reduce(
        (total, option) =>
            total + (
                Number(option.additionalPrice || 0)
                * Number(option.quantity || 1)
            ),
        0
    );


    const finalPrice =
        Number(product.price) + optionsPrice;


    const optionsKey = options
        .map(option =>
            `${option.uuid}:${option.quantity}`
        )
        .sort()
        .join('|');


    const observationKey =
        observation
            .toLowerCase()
            .replace(/\s+/g, ' ');


    const cartKey =
        `${product.id}:${optionsKey}:${observationKey}`;


    const existingProduct = cart.find(
        item => item.cartKey === cartKey
    );


    if (existingProduct) {

        existingProduct.quantity++;

    } else {

        cart.push({

            ...product,

            price: finalPrice,

            basePrice: Number(product.price),

            options: options,

            observation: observation,

            cartKey: cartKey,

            quantity: 1

        });

    }


    localStorage.setItem(
        'cart',
        JSON.stringify(cart)
    );


    updateCartCount();


    showCartToast(
        'Adicionado ao pedido'
    );


    console.log(
        'Carrinho:',
        cart
    );
}

function openProductOptionsModal(product, optionGroups) {

    const oldModal = document.getElementById(
        'product-options-modal'
    );

    if (oldModal) {
        oldModal.remove();
    }

    const modal = document.createElement('div');

    modal.id = 'product-options-modal';

    modal.innerHTML = `

        <div class="product-options-overlay"></div>

        <div class="product-options-dialog">

            <button
                type="button"
                class="product-options-close"
                id="close-product-options"
            >
                ×
            </button>

            <h2>
                ${product.name}
            </h2>

            <p class="product-options-price">
                R$ ${Number(product.price).toFixed(2)}
            </p>

            <div
                        id="product-options-content"
                    ></div>

                    <div class="product-observation">

                        <label for="product-observation-input">
                            Observações
                            <span>(opcional)</span>
                        </label>

                        <textarea
                            id="product-observation-input"
                            maxlength="250"
                            rows="3"
                            placeholder="Ex.: sem picles, sem cebola, molho à parte..."
                        ></textarea>

                        <small>
                            <span id="product-observation-count">0</span>/250 caracteres
                        </small>

                    </div>

                    <div class="product-options-footer">

                <strong id="product-options-total">
                    Total: R$ ${Number(product.price).toFixed(2)}
                </strong>

                <button
                    type="button"
                    id="confirm-product-options"
                    class="product-options-confirm"
                >
                    Adicionar ao pedido
                </button>

            </div>

        </div>
    `;

    document.body.appendChild(modal);

    const content = document.getElementById(
        'product-options-content'
    );

    const observationInput =
    document.getElementById(
        'product-observation-input'
    );

    const observationCount =
        document.getElementById(
            'product-observation-count'
        );


    if (observationInput && observationCount) {

        observationInput.addEventListener(
            'input',
            () => {

                observationCount.textContent =
                    observationInput.value.length;

            }
        );

    }

    optionGroups.forEach((group, groupIndex) => {

        const groupElement =
            document.createElement('section');

        groupElement.className =
            'product-option-group';

        const minimum =
            Number(group.minChoices || 0);

        const maximum =
            Number(group.maxChoices || 0);

        groupElement.innerHTML = `

            <div class="product-option-group-header">

                <h3>
                    ${group.name}
                </h3>

                ${
                    group.description
                        ? `<p>${group.description}</p>`
                        : ''
                }

                <small>
                    ${
                        minimum > 0
                            ? `Escolha no mínimo ${minimum}.`
                            : ''
                    }

                    ${
                        maximum > 0
                            ? `Escolha até ${maximum}.`
                            : ''
                    }
                </small>

            </div>

            <div class="product-option-items"></div>
        `;

        const itemsContainer =
            groupElement.querySelector(
                '.product-option-items'
            );

        const isSingle =
            group.selectionType === 'single';

        group.items.forEach(item => {

            const wrapper =
                document.createElement('label');

            wrapper.className =
                'product-option-item';

            wrapper.innerHTML = `

                <div class="product-option-main">

                    <input
                        type="${isSingle ? 'radio' : 'checkbox'}"
                        name="option-group-${groupIndex}"
                        value="${item.uuid}"
                        data-name="${item.name}"
                        data-price="${item.additionalPrice}"
                        data-max-quantity="${item.maxQuantity}"
                    >

                    <span>
                        <strong>
                            ${item.name}
                        </strong>

                        ${
                            item.description
                                ? `<small>${item.description}</small>`
                                : ''
                        }
                    </span>

                </div>

                <span class="product-option-price">
                    ${
                        Number(item.additionalPrice) > 0
                            ? `+ R$ ${Number(item.additionalPrice).toFixed(2)}`
                            : 'Grátis'
                    }
                </span>
            `;

            itemsContainer.appendChild(wrapper);

        });

        content.appendChild(groupElement);

    });

    updateProductOptionsTotal(product);

    document
        .querySelectorAll(
            '#product-options-content input'
        )
        .forEach(input => {

            input.addEventListener(
                'change',
                () => {

                    updateProductOptionsTotal(
                        product
                    );

                }
            );

        });

    document
        .getElementById('close-product-options')
        .addEventListener(
            'click',
            () => modal.remove()
        );

    document
        .querySelector(
            '.product-options-overlay'
        )
        .addEventListener(
            'click',
            () => modal.remove()
        );

    document
        .getElementById('confirm-product-options')
        .addEventListener(
            'click',
            () => {

                const selected =
                    getSelectedProductOptions();

                const validation =
                    validateProductOptions(
                        optionGroups,
                        selected
                    );

                if (!validation.valid) {

                    alert(validation.message);

                    return;

                }

                const observationInput =
                    document.getElementById(
                        'product-observation-input'
                    );

                const observation =
                    observationInput
                        ? observationInput.value.trim()
                        : '';


                addProductToCart(
                    product,
                    selected,
                    observation
                );

                modal.remove();

            }
        );
}

function getSelectedProductOptions() {

    const selected = [];

    document
        .querySelectorAll(
            '#product-options-content input:checked'
        )
        .forEach(input => {

            selected.push({

                uuid: input.value,

                name: input.dataset.name,

                additionalPrice:
                    Number(input.dataset.price),

                quantity: 1

            });

        });

    return selected;
}

function validateProductOptions(optionGroups, selected) {

    for (const group of optionGroups) {

        const groupItemUuids = new Set(
            group.items.map(item => item.uuid)
        );

        const selectedInGroup = selected.filter(option =>
            groupItemUuids.has(option.uuid)
        );

        const minimum = Number(group.minChoices || 0);
        const maximum = Number(group.maxChoices || 0);

        if (
            minimum > 0 &&
            selectedInGroup.length < minimum
        ) {
            return {
                valid: false,
                message:
                    `Selecione pelo menos ${minimum} opção(ões) em "${group.name}".`
            };
        }

        if (
            maximum > 0 &&
            selectedInGroup.length > maximum
        ) {
            return {
                valid: false,
                message:
                    `Você pode selecionar no máximo ${maximum} opção(ões) em "${group.name}".`
            };
        }
    }

    return {
        valid: true
    };
}

function updateProductOptionsTotal(product) {

    const selected =
        getSelectedProductOptions();

    const optionsPrice =
        selected.reduce(
            (total, option) =>
                total +
                Number(option.additionalPrice),
            0
        );

    const total =
        Number(product.price) +
        optionsPrice;

    const totalElement =
        document.getElementById(
            'product-options-total'
        );

    if (totalElement) {

        totalElement.textContent =
            `Total: R$ ${total.toFixed(2)}`;

    }
}

document.addEventListener('DOMContentLoaded', () => {

    const openCartButton =
        document.getElementById('open-cart');

    const closeCartButton =
        document.getElementById('close-cart');

    const cartPanel =
        document.getElementById('cart-panel');

    const cartOverlay =
        document.getElementById('cart-overlay');


    if (openCartButton && cartPanel && cartOverlay) {

        openCartButton.addEventListener('click', () => {

            renderCart();

            cartPanel.classList.add('active');

            cartOverlay.classList.add('active');

        });

    }


    if (closeCartButton && cartPanel && cartOverlay) {

        closeCartButton.addEventListener('click', () => {

            cartPanel.classList.remove('active');

            cartOverlay.classList.remove('active');

        });

    }


    if (cartOverlay && cartPanel) {

        cartOverlay.addEventListener('click', () => {

            cartPanel.classList.remove('active');

            cartOverlay.classList.remove('active');

        });

    }

});
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


        cartCount.classList.remove('animate');

        void cartCount.offsetWidth;

        cartCount.classList.add('animate');


    } else {

        cartCount.innerHTML = '';

    }

}


function showCartToast(message) {


    const toast = document.getElementById('cart-toast');


    if (!toast) {
        return;
    }


    toast.innerHTML = `
        ✓ ${message}
    `;


    toast.classList.add('show');


    setTimeout(() => {

        toast.classList.remove('show');

    }, 2000);


}

function escapeHtml(value) {

    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

}

// ===============================
// RENDERIZAR CARRINHO
// ===============================

function renderCart() {

    const cartItems =
        document.getElementById('cart-items');

    const cartTotal =
        document.getElementById('cart-total');

    if (!cartItems || !cartTotal) {
        return;
    }

    const cart =
        JSON.parse(
            localStorage.getItem('cart')
        ) || [];


    /*
     * CARRINHO VAZIO
     */

    if (cart.length === 0) {

        cartItems.innerHTML = `
            <p>
                Seu pedido está vazio.
            </p>
        `;

        cartTotal.textContent =
            'Total: R$ 0,00';

        return;
    }


    let total = 0;


    /*
     * RENDERIZA OS PRODUTOS
     */

    cartItems.innerHTML = cart.map(item => {

        const itemPrice =
            Number(item.price || 0);

        const basePrice =
            Number(
                item.basePrice ??
                item.price ??
                0
            );

        const quantity =
            Number(item.quantity || 1);

        const subtotal =
            itemPrice * quantity;

        total += subtotal;


        /*
         * ACOMPANHAMENTOS
         */

        let optionsHtml = '';

        if (
            Array.isArray(item.options) &&
            item.options.length > 0
        ) {

            optionsHtml = `
                <div class="cart-item-options">

                    <strong>
                        Acompanhamentos:
                    </strong>

                    ${item.options.map(option => {

                        const optionPrice =
                            Number(
                                option.additionalPrice || 0
                            );

                        const optionQuantity =
                            Number(
                                option.quantity || 1
                            );

                        return `
                            <div class="cart-option">

                                <span>
                                    ${option.name}

                                    ${
                                        optionQuantity > 1
                                            ? ` × ${optionQuantity}`
                                            : ''
                                    }
                                </span>

                                ${
                                    optionPrice > 0
                                        ? `
                                            <span>
                                                + R$
                                                ${(
                                                    optionPrice *
                                                    optionQuantity
                                                )
                                                .toFixed(2)
                                                .replace('.', ',')}
                                            </span>
                                          `
                                        : `
                                            <span>
                                                Grátis
                                            </span>
                                          `
                                }

                            </div>
                        `;

                    }).join('')}

                </div>
            `;

        }


        /*
         * PRODUTO
         */

        return `

            <div class="cart-item">

                <div class="cart-item-info">

                    <strong class="cart-item-name">
                        ${item.name}
                    </strong>


                    ${
                        item.options?.length
                            ? `
                                <span class="cart-item-base-price">
                                    Produto:
                                    R$ ${basePrice
                                        .toFixed(2)
                                        .replace('.', ',')}
                                </span>
                              `
                            : ''
                    }


                    <span class="cart-item-unit">

                        R$
                        ${itemPrice
                            .toFixed(2)
                            .replace('.', ',')}

                        cada

                    </span>


                    ${optionsHtml}


                    ${
                        item.observation
                            ? `
                                <div class="cart-item-observation">

                                    <strong>
                                        Observação:
                                    </strong>

                                    <span>
                                        ${escapeHtml(item.observation)}
                                    </span>

                                </div>
                            `
                            : ''
                    }


                    <span class="cart-item-subtotal">

                        Subtotal:
                        R$
                        ${subtotal
                            .toFixed(2)
                            .replace('.', ',')}

                    </span>

                </div>


                <div class="cart-item-actions">

                    <button
                        type="button"
                        class="decrease-button"
                        data-cart-key="${item.cartKey || item.id}"
                    >
                        -
                    </button>


                    <span class="cart-quantity">
                        ${quantity}
                    </span>


                    <button
                        type="button"
                        class="increase-button"
                        data-cart-key="${item.cartKey || item.id}"
                    >
                        +
                    </button>


                    <button
                        type="button"
                        class="remove-button"
                        data-cart-key="${item.cartKey || item.id}"
                    >
                        🗑
                    </button>

                </div>

            </div>

        `;

    }).join('');


    /*
     * TOTAL DO PEDIDO
     */

    cartTotal.textContent =
        `Total: R$ ${total
            .toFixed(2)
            .replace('.', ',')}`;


    /*
     * BOTÃO +
     */

    document
        .querySelectorAll('.increase-button')
        .forEach(button => {

            button.addEventListener(
                'click',
                () => {

                    const cartKey =
                        button.dataset.cartKey;

                    const cart =
                        JSON.parse(
                            localStorage.getItem('cart')
                        ) || [];


                    const product =
                        cart.find(
                            item =>
                                String(
                                    item.cartKey || item.id
                                ) === String(cartKey)
                        );


                    if (product) {

                        product.quantity++;

                        saveCart(cart);

                    }

                }
            );

        });


    /*
     * BOTÃO -
     */

    document
        .querySelectorAll('.decrease-button')
        .forEach(button => {

            button.addEventListener(
                'click',
                () => {

                    const cartKey =
                        button.dataset.cartKey;

                    const cart =
                        JSON.parse(
                            localStorage.getItem('cart')
                        ) || [];


                    const product =
                        cart.find(
                            item =>
                                String(
                                    item.cartKey || item.id
                                ) === String(cartKey)
                        );


                    if (!product) {
                        return;
                    }


                    product.quantity--;


                    if (product.quantity <= 0) {

                        const newCart =
                            cart.filter(
                                item =>
                                    String(
                                        item.cartKey || item.id
                                    ) !== String(cartKey)
                            );

                        saveCart(newCart);

                    } else {

                        saveCart(cart);

                    }

                }
            );

        });


    /*
     * BOTÃO EXCLUIR
     */

    document
        .querySelectorAll('.remove-button')
        .forEach(button => {

            button.addEventListener(
                'click',
                () => {

                    const cartKey =
                        button.dataset.cartKey;

                    const cart =
                        JSON.parse(
                            localStorage.getItem('cart')
                        ) || [];


                    const newCart =
                        cart.filter(
                            item =>
                                String(
                                    item.cartKey || item.id
                                ) !== String(cartKey)
                        );


                    saveCart(newCart);

                }
            );

        });

}

function saveCart(cart) {

    localStorage.setItem(
        'cart',
        JSON.stringify(cart)
    );

    updateCartCount();

    renderCart();
}