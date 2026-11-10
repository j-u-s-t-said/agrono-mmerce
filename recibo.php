<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agronomex - Catálogo y Carrito</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style_rec.css">
    <link rel="stylesheet" href="home_style.css">
    <link rel="stylesheet" href="style_modal.css">
    <link rel="stylesheet" href="style_rec2.css">
    <link rel="icon" href="Imagenes/WhatsApp_Image_2024-06-17_at_9.00.39_PM-removebg-preview.png">
    
    <style>
        :root {
            --header-bg: #2b2e2b;
            --brand-green: #388e3c;
            --dark-green: #1b5e20;
            --light-green: #e8f5e9;
            --card-bg: rgba(255, 255, 255, 0.95);
            --text-dark: #212121;
            --text-muted: #666666;
            --border-color: #dddddd;
        }

        body {
            background: linear-gradient(rgba(27, 94, 32, 0.65), rgba(46, 125, 50, 0.75)), 
                        url('Imagenes/Agro.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .user-profile-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-left: 15px;
        }
        .logo-area {
            display: flex;
            align-items: center;
        }

        .shop-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 15px;
            display: grid;
            grid-template-columns: 2.2fr 1fr;
            gap: 25px;
            flex: 1;
        }

        .section-box {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 25px;
            border: 1px solid rgba(255,255,255,0.3);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            backdrop-filter: blur(5px);
            height: fit-content;
        }

        .box-title {
            font-size: 1.3rem;
            color: var(--dark-green);
            margin-bottom: 20px;
            border-bottom: 2px solid var(--brand-green);
            padding-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 20px;
        }

        .product-card {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 15px;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.3s ease;
            box-shadow: 0 3px 8px rgba(0,0,0,0.05);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.18);
            border-color: var(--brand-green);
        }

        .product-img-container {
            width: 100%;
            height: 130px;
            background: #f0f0f0;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-card h4 {
            font-size: 1.05rem;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .product-card .price {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--dark-green);
            margin-bottom: 8px;
        }

        .selector-group {
            margin-bottom: 10px;
        }

        .selector-group label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            display: block;
            margin-bottom: 3px;
        }

        .selector-group select {
            width: 100%;
            padding: 6px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 0.85rem;
            outline: none;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f1f8e9;
            border-radius: 6px;
            padding: 4px 10px;
            margin-bottom: 12px;
        }

        .quantity-control button {
            background: var(--dark-green);
            color: #fff;
            border: none;
            width: 26px;
            height: 26px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-control button:hover {
            background: var(--brand-green);
        }

        .quantity-control span {
            font-weight: bold;
            font-size: 0.95rem;
        }

        .btn-add-cart {
            background-color: var(--dark-green);
            color: #fff;
            border: none;
            padding: 9px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
        }

        .btn-add-cart:hover {
            background-color: var(--brand-green);
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            font-size: 0.9rem;
        }

        .btn-remove {
            background: none;
            border: none;
            color: #d32f2f;
            cursor: pointer;
            font-size: 1rem;
            padding: 4px;
        }

        .cart-total-section {
            margin-top: 20px;
            border-top: 2px solid #333;
            padding-top: 12px;
        }

        .cart-total-row {
            display: flex;
            justify-content: space-between;
            font-size: 1.1rem;
            font-weight: bold;
            color: var(--dark-green);
            margin-bottom: 15px;
        }

        .btn-checkout {
            width: 100%;
            background-color: #ff8f00;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-checkout:hover {
            background-color: #ffa000;
        }

        .empty-cart-msg {
            color: var(--text-muted);
            text-align: center;
            padding: 20px 0;
            font-size: 0.9rem;
        }

        @media (max-width: 900px) {
            .shop-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Barra de Navegación con Perfil -->
    <header>
        <div class="logo-area">
            <div class="logo">
                <a href="home.php">
                    <img src="Imagenes/WhatsApp_Image_2024-06-17_at_9.00.39_PM-removebg-preview.png" alt="Logo">
                </a>
            </div>
            <div class="user-profile-badge">
                <i class="fas fa-user-circle" style="color: #4CAF50;"></i>
                <span><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
            </div>
        </div>

        <nav class="nav-links" id="navLinks">
            <ul>
                <li><a href="nosotros.html">Nosotros</a></li>
                <li>
                    <a>Productos</a>
                    <ul>
                        <li><a href="product1.html">Agroraise</a></li>
                        <li><a href="product2.html">VeintiZinc</a></li>
                        <li><a href="product3.html">Cytostim</a></li>
                        <li><a href="product4.html">Resin Oil</a></li>
                    </ul>
                </li>
                <li><a href="recibo.php">Compras</a></li>
            </ul>
        </nav>
        <a href="javascript:void(0);" class="icon" onclick="toggleNav()">
            <i class="fa fa-bars"></i>
        </a>
    </header>

    <div class="shop-container">
        <!-- Izquierda: Catálogo -->
        <div class="section-box">
            <h2 class="box-title"><i class="fas fa-seedling"></i> Catálogo de Fertilizantes Agronomex</h2>
            <div id="no-record-message" class="empty-cart-msg" style="display: none;">No hay productos disponibles.</div>
            <div class="products-grid" id="product-list"></div>
        </div>

        <!-- Derecha: Carrito Sincronizado -->
        <div class="section-box cart-container-box">
            <div>
                <h2 class="box-title"><i class="fas fa-shopping-cart"></i> Tu Carrito (<span id="cart-counter">0</span>)</h2>
                <div id="cart-items-container" style="max-height: 320px; overflow-y: auto;">
                    <div class="empty-cart-msg">Tu carrito está vacío</div>
                </div>
            </div>

            <div class="cart-total-section">
                <div class="cart-total-row">
                    <span>Total estimado:</span>
                    <span id="cart-total-val">$0.00</span>
                </div>
                <button class="btn-checkout" onclick="procederAlTicket()">
                    <i class="fas fa-cash-register"></i> Proceder al Pago y Envío
                </button>
            </div>
        </div>
    </div>

    <footer class="footer" style="background: rgba(30,30,30,0.9); color: #fff; padding: 20px; text-align: center;">
        <div class="footer-content">
            <h3>AGRONO-MMERCE</h3>
            <p>© 2023 AGRONO-MMERCE. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        let carrito = [];

        function toggleNav() {
            const nav = document.getElementById('navLinks');
            nav.classList.toggle('active');
        }

        function cargarDatosIniciales() {
            fetch('obtener_productos.php')
            .then(response => response.text())
            .then(str => {
                const parser = new DOMParser();
                const xml = parser.parseFromString(str, "application/xml");
                const availableProducts = xml.getElementsByTagName('producto');
                const listaProductos = document.getElementById('product-list');
                const noRecordMessage = document.getElementById('no-record-message');

                listaProductos.innerHTML = '';

                if (availableProducts.length === 0) {
                    noRecordMessage.style.display = 'block';
                } else {
                    noRecordMessage.style.display = 'none';
                    for (let i = 0; i < availableProducts.length; i++) {
                        const id = availableProducts[i].getElementsByTagName('id')[0]?.textContent || i;
                        const nombre = availableProducts[i].getElementsByTagName('nombre')[0].textContent;
                        const precioBase = parseFloat(availableProducts[i].getElementsByTagName('precio')[0].textContent);
                        
                        let imagenUrl = "Imagenes/AGRIMGORIGI.jpeg";
                        if (nombre.toLowerCase().includes('agroraise')) {
                            imagenUrl = "Imagenes/AGRIMGORIGI.jpeg";
                        } else if (nombre.toLowerCase().includes('zinc')) {
                            imagenUrl = "Imagenes/veintizinc.jpg";
                        }

                        const card = document.createElement('div');
                        card.className = 'product-card';
                        card.innerHTML = `
                            <div>
                                <div class="product-img-container">
                                    <img src="${imagenUrl}" alt="${nombre}" onerror="this.src='Imagenes/AGRIMGORIGI.jpeg'">
                                </div>
                                <h4>${nombre}</h4>
                                <div class="price" id="price-${id}">$${precioBase.toFixed(2)}</div>
                                
                                <div class="selector-group">
                                    <label>Presentación:</label>
                                    <select id="pres-${id}" onchange="cambiarPresentacion('${id}', ${precioBase})">
                                        <option value="1kg">Caja de 1kg (1kg neto)</option>
                                        <option value="15kg" selected>Presentación 15kg</option>
                                    </select>
                                </div>

                                <div class="selector-group">
                                    <label>Cantidad:</label>
                                    <div class="quantity-control">
                                        <button onclick="cambiarCant('${id}', -1)">-</button>
                                        <span id="qty-${id}">1</span>
                                        <button onclick="cambiarCant('${id}', 1)">+</button>
                                    </div>
                                </div>
                            </div>

                            <button class="btn-add-cart" onclick="agregarAlCarrito('${id}', '${nombre}', ${precioBase})">
                                <i class="fas fa-cart-plus"></i> Agregar
                            </button>
                        `;
                        listaProductos.appendChild(card);
                    }
                }
                // Después de cargar el catálogo, recuperamos el carrito del usuario de la BD
                cargarCarritoBD();
            })
            .catch(err => console.error("Error cargando productos:", err));
        }

        function cambiarPresentacion(id, precioBase) {
            const select = document.getElementById(`pres-${id}`);
            const priceEl = document.getElementById(`price-${id}`);
            let precioFinal = select.value === '1kg' ? precioBase / 15 : precioBase;
            priceEl.textContent = `$${precioFinal.toFixed(2)}`;
        }

        function cambiarCant(id, cambio) {
            const qtySpan = document.getElementById(`qty-${id}`);
            let actual = parseInt(qtySpan.textContent) + cambio;
            if (actual < 1) actual = 1;
            qtySpan.textContent = actual;
        }

        function sincronizarConBD() {
            fetch('guardar_carrito.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ carrito: carrito })
            })
            .then(res => res.text())
            .then(data => console.log("BD Sincronizada:", data));
        }

        function cargarCarritoBD() {
            fetch('obtener_carrito.php')
            .then(res => res.json())
            .then(data => {
                if (Array.isArray(data)) {
                    carrito = data.map(item => ({
                        cartId: `${item.id}-${item.unidad === 'cajas' ? '1kg' : '15kg'}`,
                        id: item.id,
                        nombre: item.nombre,
                        precio: parseFloat(item.precio),
                        cantidad: parseInt(item.cantidad),
                        unidad: item.unidad
                    }));
                    actualizarContadorCarrito();
                    renderizarCarrito();
                }
            })
            .catch(err => console.error("Error al cargar carrito desde BD:", err));
        }

        function agregarAlCarrito(id, nombre, precioBase) {
            const select = document.getElementById(`pres-${id}`);
            const presentacion = select.value;
            const cantidadSeleccionada = parseInt(document.getElementById(`qty-${id}`).textContent);
            
            let precioUnitario = presentacion === '1kg' ? precioBase / 15 : precioBase;
            let unidadTexto = presentacion === '1kg' ? 'Caja 1kg' : 'Presentación 15kg';

            const cartId = `${id}-${presentacion}`;
            const index = carrito.findIndex(item => item.cartId === cartId);

            if (index > -1) {
                carrito[index].cantidad += cantidadSeleccionada;
            } else {
                carrito.push({
                    cartId,
                    id: id,
                    nombre: `${nombre} (${unidadTexto})`,
                    precio: precioUnitario,
                    cantidad: cantidadSeleccionada,
                    unidad: presentacion === '1kg' ? 'cajas' : 'pzas'
                });
            }

            document.getElementById(`qty-${id}`).textContent = '1';
            actualizarContadorCarrito();
            renderizarCarrito();
            sincronizarConBD(); // Guarda inmediatamente en MySQL
        }

        function eliminarDelCarrito(index) {
            carrito.splice(index, 1);
            actualizarContadorCarrito();
            renderizarCarrito();
            sincronizarConBD(); // Actualiza MySQL tras eliminar
        }

        function actualizarContadorCarrito() {
            const totalItems = carrito.reduce((sum, item) => sum + item.cantidad, 0);
            document.getElementById('cart-counter').textContent = totalItems;
        }

        function renderizarCarrito() {
            const container = document.getElementById('cart-items-container');
            const totalVal = document.getElementById('cart-total-val');
            
            container.innerHTML = '';

            if (carrito.length === 0) {
                container.innerHTML = `<div class="empty-cart-msg">Tu carrito está vacío</div>`;
                totalVal.textContent = '$0.00';
                return;
            }

            let subtotalGeneral = 0;

            carrito.forEach((item, index) => {
                const totalItem = item.precio * item.cantidad;
                subtotalGeneral += totalItem;

                const div = document.createElement('div');
                div.className = 'cart-item';
                div.innerHTML = `
                    <div>
                        <strong>${item.nombre}</strong><br>
                        <small style="color:#666">${item.cantidad} ${item.unidad} x $${item.precio.toFixed(2)}</small>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-weight:600;">$${totalItem.toFixed(2)}</span>
                        <button class="btn-remove" onclick="eliminarDelCarrito(${index})" title="Eliminar"><i class="fas fa-trash"></i></button>
                    </div>
                `;
                container.appendChild(div);
            });

            totalVal.textContent = `$${subtotalGeneral.toFixed(2)}`;
        }

        function procederAlTicket() {
            if (carrito.length === 0) {
                alert('Agrega al menos un producto al carrito para proceder.');
                return;
            }

            const ticketData = carrito.map(item => ({
                id: item.id,
                nombre: item.nombre,
                precio: item.precio,
                cantidad: item.cantidad,
                unidad: item.unidad
            }));

            sessionStorage.setItem('ticketData', JSON.stringify(ticketData));
            window.location.href = 'ticket.html';
        }

        document.addEventListener('DOMContentLoaded', cargarDatosIniciales);
    </script>
</body>
</html>