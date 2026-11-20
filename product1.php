<?php
session_start();
$isLoggedIn = isset($_SESSION['usuario']);
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agroraise - Agronomex</title>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="home_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="Imagenes/WhatsApp_Image_2024-06-17_at_9.00.39_PM-removebg-preview.png"> 
    <style>
        .product-gallery { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 20px 0; }
        .product-gallery img { width: 100%; height: 220px; object-fit: cover; border-radius: 10px; border: 1px solid #ddd; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; }
        .product-gallery img:hover { transform: scale(1.04); box-shadow: 0 8px 16px rgba(0,0,0,0.2); }
        .btn-ir-carrito { background-color: #ff8f00; color: white; border: none; padding: 12px 20px; border-radius: 25px; font-weight: bold; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: background 0.2s; margin-top: 10px; }
        .btn-ir-carrito:hover { background-color: #ffa000; }
        @media (max-width: 700px) { .product-gallery { grid-template-columns: 1fr; } }

        /* Estilo mejorado para la galería y el visor flotante (Modal de Imagen) */
.product-gallery { 
    display: grid; 
    grid-template-columns: repeat(3, 1fr); 
    gap: 20px; 
    margin: 20px 0; 
}
.product-gallery img { 
    width: 100%; 
    height: 200px; 
    object-fit: cover; 
    border-radius: 10px; 
    border: 1px solid #ddd; 
    box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
    cursor: pointer; 
    transition: opacity 0.2s; 
}
.product-gallery img:hover { 
    opacity: 0.85; 
}

/* Modal / Visor de imagen grande */
.img-modal-overlay {
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.85);
    justify-content: center;
    align-items: center;
}
.img-modal-content {
    max-width: 90%;
    max-height: 85vh;
    border-radius: 8px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.5);
    object-fit: contain;
}
.img-modal-close {
    position: absolute;
    top: 20px;
    right: 30px;
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}
    </style>
</head>
<body>
    <header>
        <div class="logo-area" style="display: flex; align-items: center;">
            <div class="logo">
                <a href="home.php">
                    <img src="Imagenes/WhatsApp_Image_2024-06-17_at_9.00.39_PM-removebg-preview.png" alt="Logo">
                </a>
            </div>
            <?php if ($isLoggedIn): ?>
                <div class="user-profile-badge" style="display: flex; align-items: center; gap: 8px; color: #fff; background: rgba(255, 255, 255, 0.1); padding: 6px 12px; border-radius: 20px; font-size: 0.9rem; margin-left: 15px;">
                    <i class="fas fa-user-circle" style="color: #4CAF50;"></i>
                    <span><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
                </div>
            <?php endif; ?>
        </div>
        <nav class="nav-links" id="navLinks">
            <ul>
                <li><a href="nosotros.php">Nosotros</a></li>
                <li>
                    <a>Productos</a>
                    <ul>
                        <li><a href="product1.php">Agroraise</a></li>
                        <li><a href="product2.php">VeintiZinc</a></li>
                        <li><a href="product3.php">Agroimpulse</a></li>
                        <li><a href="product4.php">Resin Oil</a></li>
                    </ul>
                </li>
                <?php if ($current_page !== 'recibo.php'): ?>
                    <li><a href="recibo.php">Compras</a></li>
                <?php endif; ?>
                <?php if (!$isLoggedIn): ?>
                    <li><a href="index.php" style="background-color: #4CAF50; color: white !important; padding: 8px 16px !important; border-radius: 20px; font-weight: bold;"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <a href="javascript:void(0);" class="icon" onclick="toggleNav()"><i class="fa fa-bars"></i></a>
    </header>

    <section class="main-title">
        <h1>Agroraise</h1>
    </section>

    <main>
        <section class="content-section">
            <div class="content-box">
                <h2>¿Que es?</h2>
                <p>Es un Regulador de crecimiento tipo 1, con acción de enraizador y fertilizante de alto desempeño. Especializado en la estimulación de la planta para la generación y mantenimiento de raíces, además del desarrollo de tallos y ramas fuertes[cite: 30].</p>
            </div>
            <div class="content-box">
                <h2>Formula</h2>
                <p>Posee una fórmula balanceada de nutrientes (N, P, Zn, Fe, Ca y Si) que fortalece y nutre a la planta, más fitohormonas enraizadoras tipo auxinas[cite: 30].</p>
            </div>
        </section>

        <!-- Galería de 3 Imágenes del Producto -->
        <section class="content-section">
            <div class="content-box" style="max-width: 1400px; width: 100%;">
                <h2>Galería del Producto</h2>
                <div class="product-gallery">
                    <img src="Imagenes/agroraise_1.jpg" alt="Agroraise 1" onerror="this.src='Imagenes/AGRIMGORIGI.jpeg'">
                    <img src="Imagenes/agroraise_2.jpg" alt="Agroraise 2" onerror="this.src='Imagenes/AGRIMGORIGI.jpeg'">
                    <img src="Imagenes/agroraise_3.jpg" alt="Agroraise 3" onerror="this.src='Imagenes/AGRIMGORIGI.jpeg'">
                </div>
            </div>
        </section>

        <section class="content-section">
            <div class="content-box3">
                <h2>¡Compralo ya!</h2>
                <p>La división celular propicia la generación de raíces nuevas. Aplícalo de forma sencilla y segura en tus cultivos[cite: 30].</p>
                <button class="btn-ir-carrito" onclick="comprarDirecto('p1', 'Agroraise', 550.00)">
                    <i class="fas fa-cart-plus"></i> Ir al Carrito
                </button>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <h3>AGRONO-MMERCE</h3>
            <p>© 2023 AGRONO-MMERCE. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script>
        const usuarioLogueado = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
        function toggleNav() { document.getElementById("navLinks").classList.toggle("show"); }
        
        function comprarDirecto(id, nombre, precio) {
            if (!usuarioLogueado) {
                alert("Debes iniciar sesión para comprar productos.");
                window.location.href = "index.php";
                return;
            }
            const itemUnico = [{ id: id, nombre: nombre + " (Presentación 15kg)", precio: precio, cantidad: 1, unidad: "pzas" }];
            fetch('guardar_carrito.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ carrito: itemUnico })
            }).then(() => {
                window.location.href = "recibo.php";
            });
        }

        // Funcionalidad para abrir la imagen en grande al hacer clic
document.addEventListener("DOMContentLoaded", function() {
    const galeriaImgs = document.querySelectorAll('.product-gallery img');
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('imgModalSrc');

    galeriaImgs.forEach(img => {
        img.addEventListener('click', function() {
            modal.style.display = "flex";
            modalImg.src = this.src;
        });
    });
});

function cerrarModalImg() {
    document.getElementById('imageModal').style.display = "none";
}
    </script>

    <!-- Modal flotante para ampliar imagen -->
<div id="imageModal" class="img-modal-overlay" onclick="cerrarModalImg()">
    <span class="img-modal-close">&times;</span>
    <img class="img-modal-content" id="imgModalSrc">
</div>
</body>
</html>