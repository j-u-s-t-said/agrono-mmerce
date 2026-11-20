<?php
session_start();
$isLoggedIn = isset($_SESSION['usuario']);
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pagina comercial y publicitaria.">
    <meta name="keywords" content="Tienda, comercial, fertilizantes">
    <title>AGRONO-MMERCE</title>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="home_style.css">
    <link rel="icon" href="Imagenes/WhatsApp_Image_2024-06-17_at_9.00.39_PM-removebg-preview.png"> 
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
                <li><a href="index.php" class="btn-login-nav" style="background-color: #4CAF50; color: white !important; padding: 8px 16px !important; border-radius: 20px; font-weight: bold;"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <a href="javascript:void(0);" class="icon" onclick="toggleNav()">
        <i class="fa fa-bars"></i>
    </a>
</header>

    <section class="main-title">
        <h1>¿QUIENES SOMOS?</h1>
        <p>AGRONO-MMERCE</p>
    </section>

    <main>
        <section class="content-section">
            <div class="content-box">
                <h2>AGRONO-MMERCE</h2>
                <p>Somos un Laboratorio de Desarrollo de tecnologias de nutrición, bioestimulacion y bioprotección de cultivos agricolas, creado desde 2019, por expertos en ciencias agricolas y agronegocios.</p>
            </div>
            <div class="content-box">
                <h2>Desarrollo</h2>
                <p>Desarrollamos productos en 3 rutas tecnologicas: Nutricion, Bioestimulacion y Bioproteccion.</p>
            </div>
        </section>
        <section class="content-section">
            <div class="content-box3">
                <h2>Sencillos</h2>
                <p>Lo hacemos sencillo: nuestros productos son faciles de aplicar y son de bajo impacto ambiental.</p>
            </div>
        </section>
    </main>
    

    <footer class="footer">
        <div class="footer-content">
            <h3>AGRONO-MMERCE</h3>
            <p>
                Somos una empresa dedicada a la venta de fertilizantes y productos agrícolas. Nuestro compromiso es 
                proporcionar productos de alta calidad que ayuden a transformar y mejorar el rendimiento de los cultivos.
            </p>
            <p>© 2023 AGRONO-MMERCE. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script>
        function toggleNav() {
            var navLinks = document.getElementById("navLinks");
            navLinks.classList.toggle("show");
        }
    


    </script>
</body>
</html>