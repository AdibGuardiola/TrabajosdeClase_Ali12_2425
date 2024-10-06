document.addEventListener("DOMContentLoaded", function() {
    // Añadir el evento click al icono del carrito solo cuando el DOM esté cargado
    const cartIcon = document.querySelector('.nav-icon-container a[href="#"]');
    if (cartIcon) {
        cartIcon.addEventListener('click', function(event) {
            event.preventDefault();
            showCart();
        });
    }

    const cartButtons = document.querySelectorAll('.add-to-cart');
    cartButtons.forEach(button => {
        button.addEventListener('click', function() {
            addToCart.call(this);
        });
    });
});

function addToCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const productId = this.dataset.id;
    const productName = this.dataset.name;
    const productImage = this.dataset.image;
    const productPrice = parseFloat(this.dataset.price);

    const productExists = cart.find(item => item.id === productId);
    if (productExists) {
        productExists.quantity += 1;
    } else {
        cart.push({
            id: productId,
            name: productName,
            image: productImage,
            price: productPrice,
            quantity: 1
        });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    alert(`${productName} añadido al carrito.`);
}

function showCart() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsDiv = document.getElementById('cartItems');
    let total = 0;

    if (cart.length === 0) {
        cartItemsDiv.innerHTML = "El carrito está vacío.";
    } else {
        let cartDetails = cart.map(item => {
            total += item.price * item.quantity;
            return `
            <div>
                <img src="${item.image}" alt="${item.name}" style="width:50px; height:50px;">
                <p>${item.name} - Cantidad: ${item.quantity}</p>
                <p>Precio: ${item.price.toFixed(2)}€</p>
                <p>Total: ${(item.price * item.quantity).toFixed(2)}€</p>
                <button onclick="removeFromCart('${item.id}')">Eliminar</button>
            </div>
            `;
        }).join('');
        cartItemsDiv.innerHTML = cartDetails;
        cartItemsDiv.innerHTML += `<p><strong>Total del Carrito: ${total.toFixed(2)}€</strong></p>`;
    }

    document.getElementById('cartModal').style.display = 'block';
}

function removeFromCart(productId) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(item => item.id !== productId);

    localStorage.setItem('cart', JSON.stringify(cart));
    showCart();
}

function closeCart() {
    document.getElementById('cartModal').style.display = 'none';
}

function clearCart() {
    localStorage.removeItem('cart');
    showCart();
}
