<?php
session_start(); // Iniciar la sesión para verificar si el usuario está logueado
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Futurista de Zapatillas</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
    font-family: Arial, sans-serif; 
    background-color: #f0f0f0; 
    color: #333; 
    padding-top: 60px; 
}
nav { 
    background-color: #fff; 
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
    padding: 1rem; 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    position: fixed; 
    top: 0; 
    left: 0; 
    right: 0; 
    z-index: 1000; 
}
nav h1 { 
    color: #000; 
    font-size: 1.5rem; 
    font-weight: bold; 
    letter-spacing: 2px; 
}
.nav-buttons { 
    display: flex; 
    gap: 1rem; 
}
.nav-buttons ul { 
    list-style: none; 
    display: flex; 
    gap: 1rem; 
}
.nav-buttons ul li { 
    list-style: none; 
}
.nav-button, .nav-link {
    background-color: #007bff; 
    color: white; 
    border: none; 
    cursor: pointer; 
    font-size: 0.9rem; 
    display: flex; 
    align-items: center; 
    padding: 0.3rem 0.5rem; 
    border-radius: 5px; 
    transition: background-color 0.3s; 
    text-decoration: none; 
}
.nav-button:hover, .nav-link:hover { 
    background-color: #0056b3; 
}
.nav-link {
    padding: 0.5rem 1rem;
    border-radius: 5px;
}

        .slider-container { width: 70%; max-width: 1100px; height: 500px; margin: 2rem auto; perspective: 1800px; overflow: hidden; }
        .slider { width: 100%; height: 100%; position: relative; transform-style: preserve-3d; transition: transform 1s ease; }
        .slide { position: absolute; width: 40%; height: 300px; left: 50%; top: 50%; margin-left: -20%; margin-top: -150px; transform-style: preserve-3d; transition: transform 1s; }
        .slide .frontside, .slide .backside { position: absolute; width: 100%; height: 100%; backface-visibility: hidden; display: flex; flex-direction: column; justify-content: space-between; align-items: center; border-radius: 10px; padding: 0.8rem; transition: transform 0.6s; transform-style: preserve-3d; }
        .slide .frontside { background-color: #fff; color: #000; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); }
        .slide .backside { background-color: #007bff; color: #fff; transform: rotateY(180deg); }
        .slide.flip .frontside { transform: rotateY(180deg); }
        .slide.flip .backside { transform: rotateY(0deg); }
        .product-image { width: 200px; height: 200px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
        .button { background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 0.9rem; transition: background-color 0.3s; }
        .button:hover { background-color: #0056b3; }
        .details-button { padding: 0.4rem 1.2rem; width: auto; }
        .button-group { display: flex; width: 100%; }
        .add-to-cart-button { padding: 0.2rem 0.4rem; width: 50%; border-right: 1px solid white; }
        .back-button { padding: 0.2rem 0.4rem; width: 50%; }
        .nav-buttons-slider { display: flex; justify-content: center; gap: 2rem; margin-top: 1rem; }
        .nav-buttons-slider .button { font-size: 0.9rem; padding: 0.4rem 0.8rem; width: auto; border-radius: 3px; }
        .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }
        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close-btn:hover,
        .close-btn:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<nav>
        <h1>Futuristic Sneakers</h1>
        <div class="nav-buttons">
            <ul>
                <!-- Verifica si el usuario está logueado -->
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-link">Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                    <li><a href="php/logout.php" class="nav-button">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><button class="nav-button" id="loginButton">Login</button></li>
                    <li><button class="nav-button" id="registerButton">Crear Cuenta</button></li>
                <?php endif; ?>
                <li><button class="nav-button" id="cartButton">Carrito (0)</button></li>
            </ul>
        </div>
    </nav>
    
    <div class="slider-container">
        <div class="slider" id="slider"></div>
    </div>

    <div class="nav-buttons-slider">
        <button class="button" onclick="rotateSlider(-72)">⬅️ Anterior</button>
        <button class="button" onclick="rotateSlider(72)">Siguiente ➡️</button>
    </div>

    <!-- Modal del Carrito de Compras -->
    <div id="cartModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Carrito de Compras</h2>
            <div id="cartItems"></div>
            <p id="totalCart"></p>
            <button id="clearCartButton">Vaciar Carrito</button>
            <button id="closeModalButton">Cerrar</button>
        </div>
    </div>

<!-- Modal de login -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Login</h2>
            <form action="php/login.php" method="post">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required><br>
                <button type="submit">Ingresar</button>
            </form>
        </div>
    </div>

    <!-- Modal de registro -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Registro</h2>
            <form action="php/register.php" method="post">
                <label for="username">Nombre de usuario:</label>
                <input type="text" id="reg_username" name="username" required><br>
                <label for="email">Email:</label>
                <input type="email" id="reg_email" name="email" required><br>
                <label for="password">Contraseña:</label>
                <input type="password" id="reg_password" name="password" required><br>
                <button type="submit">Registrarse</button>
            </form>
        </div>
    </div>
    


    <script>
const products = [
    { id: 1, name: "Zapatilla Futurista 1", price: 149.99, image: "1.png", description: "Estas zapatillas están diseñadas con tecnología de última generación para garantizar una máxima velocidad." },
    { id: 2, name: "Zapatilla Futurista 2", price: 199.99, image: "2.png", description: "Con un diseño aerodinámico y futurista, estas zapatillas ofrecen una experiencia de ligereza única." },
    { id: 3, name: "Zapatilla Futurista 3", price: 179.99, image: "3.png", description: "Una combinación de estilo y funcionalidad, perfectas para quienes quieren destacar en el futuro." },
    { id: 4, name: "Zapatilla Futurista 4", price: 129.99, image: "4.png", description: "Su amortiguación avanzada te hará sentir como si caminaras en el aire, llevándote al futuro." },
    { id: 5, name: "Zapatilla Futurista 5", price: 159.99, image: "5.png", description: "Diseñadas para quienes no temen desafiar los límites, estas zapatillas son el futuro del rendimiento." }
];


        let cart = [];
        let currentRotation = 0;

        document.addEventListener('DOMContentLoaded', () => {
            createProductSlides();
            setupEventListeners();
        });

        function createProductSlides() {
    const slider = document.getElementById("slider");
    products.forEach((product, index) => {
        const slide = document.createElement("div");
        slide.className = "slide";
        slide.id = `slide${product.id}`;
        slide.style.transform = `rotateY(${index * 72}deg) translateZ(400px)`;

        const frontside = document.createElement("div");
        frontside.className = "frontside";
        frontside.innerHTML = `
            <img src="images/${product.image}" alt="${product.name}" class="product-image">
            <div class="product-info">
                <h2 class="product-name">${product.name}</h2>
                <p class="product-price">$${product.price.toFixed(2)}</p>
                <button class="button details-button" data-slide-id="slide${product.id}">Ver detalles</button>
            </div>
        `;

        const backside = document.createElement("div");
        backside.className = "backside";
        backside.innerHTML = `
            <h3>Detalles del Producto</h3>
            <p>${product.description}</p>
            <div class="button-group">
                <button class="button add-to-cart-button" data-product-id="${product.id}">Añadir al carrito</button>
                <button class="button back-button" data-slide-id="slide${product.id}">Volver</button>
            </div>
        `;

        slide.appendChild(frontside);
        slide.appendChild(backside);
        slider.appendChild(slide);
    });
}


        function setupEventListeners() {
            const cartButton = document.getElementById('cartButton');
            const cartModal = document.getElementById('cartModal');
            const closeBtn = cartModal.querySelector('.close-btn');
            const clearCartButton = document.getElementById('clearCartButton');
            const closeModalButton = document.getElementById('closeModalButton');

            cartButton.addEventListener('click', showCart);
            closeBtn.addEventListener('click', closeModal);
            clearCartButton.addEventListener('click', clearCart);
            closeModalButton.addEventListener('click', closeModal);

            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('details-button') || e.target.classList.contains('back-button')) {
                    flipCard(e.target.dataset.slideId);
                }
                if (e.target.classList.contains('add-to-cart-button')) {
                    addToCart(parseInt(e.target.dataset.productId));
                }
            });

            window.addEventListener('click', (e) => {
                if (e.target === cartModal) {
                    closeModal();
                }
            });
        }

        function rotateSlider(degrees) {
            currentRotation += degrees;
            document.getElementById("slider").style.transform = `rotateY(${currentRotation}deg)`;
        }

        function flipCard(slideId) {
            const slide = document.getElementById(slideId);
            slide.classList.toggle('flip');
        }

        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            cart.push(product);
            updateCartDisplay();
            alert(`Producto ${product.name} añadido al carrito`);
        }

        function updateCartDisplay() {
            const cartButton = document.getElementById('cartButton');
            cartButton.textContent = `Carrito (${cart.length})`;
        }

        function showCart() {
            const cartItems = document.getElementById('cartItems');
            const totalCart = document.getElementById('totalCart');
            
            cartItems.innerHTML = cart.map(item => `<p>${item.name} - $${item.price.toFixed(2)}</p>`).join('');
            
            const total = cart.reduce((acc, curr) => acc + curr.price, 0);
            totalCart.textContent = `Total: $${total.toFixed(2)}`;
            
            document.getElementById('cartModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('cartModal').style.display = 'none';
        }

        function clearCart() {
            cart = [];
            updateCartDisplay();
            showCart(); // Actualiza la visualización del carrito vacío
        }
    </script>
    <script src="manejo_modal.js"></script>
</body>
</html>