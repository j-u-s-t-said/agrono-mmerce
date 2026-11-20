<?php
session_start();
$isLoggedIn = isset($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pagina comercial y publicitaria.">
    <meta name="keywords" content="Tienda, comercial, fertilizantes">
    <title>AGRONO-MMERCE</title>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="home_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="Imagenes/WhatsApp_Image_2024-06-17_at_9.00.39_PM-removebg-preview.png"> 
    <style>
        /* Estilo para el perfil con menú desplegable */
        .user-menu-container {
            position: relative;
            display: inline-block;
            margin-left: 15px;
        }
        .user-profile-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.9rem;
            cursor: pointer;
            user-select: none;
            transition: background 0.3s ease;
        }
        .user-profile-badge:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #2b2e2b;
            min-width: 150px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.3);
            border-radius: 8px;
            overflow: hidden;
            z-index: 1000;
            margin-top: 5px;
        }
        .dropdown-menu a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            transition: background 0.2s;
        }
        .dropdown-menu a:hover {
            background-color: #d9534f; /* Color rojo sutil para cerrar sesión */
        }
        .user-menu-container.active .dropdown-menu {
            display: block;
        }

        .logo-area {
            display: flex;
            align-items: center;
        }
        .btn-login-nav {
            background-color: #4CAF50;
            color: white !important;
            padding: 8px 16px !important;
            border-radius: 20px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .btn-login-nav:hover {
            background-color: #45a049 !important;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        main {
            flex: 1;
        }
        .footer {
            margin-top: auto;
        }
    </style>
</head>
<body>
    <?php if ($isLoggedIn): ?>
        <div id="popupMessage" class="popup-message">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></div>
    <?php endif; ?>

    <header>
        <div class="logo-area">
            <div class="logo">
                <a href="home.php">
                    <img src="Imagenes/WhatsApp_Image_2024-06-17_at_9.00.39_PM-removebg-preview.png" alt="Logo">
                </a>
            </div>
            
            <?php if ($isLoggedIn): ?>
                <!-- Menú desplegable del perfil -->
                <div class="user-menu-container" id="userMenuContainer">
                    <div class="user-profile-badge" onclick="toggleUserMenu(event)">
                        <i class="fas fa-user-circle" style="color: #4CAF50;"></i>
                        <span><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
                        <i class="fas fa-caret-down" style="font-size: 0.8rem; margin-left: 4px;"></i>
                    </div>
                    <div class="dropdown-menu">
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                    </div>
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
                        <li><a href="product4.php">Resin Oil </a></li>
                    </ul>
                </li>
                <li><a href="recibo.php">Compras</a></li>
                
                <!-- Botón dinámico según sesión -->
                <?php if (!$isLoggedIn): ?>
                    <li><a href="index.php" class="btn-login-nav"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <a href="javascript:void(0);" class="icon" onclick="toggleNav()">
            <i class="fa fa-bars"></i>
        </a>        
    </header>

    <section class="main-title">
        <h1>AGRONO-MMERCE</h1>
        <p>Transformando el campo</p>
    </section>

    <main>
        <section class="content-section">
            <div class="content-box">
                <h2>Producción</h2>
                <p>Manejamos 4 líneas de Productos: Bioprotección, Bioestimulación, Nutrientes Coadyuvantes.</p>
            </div>
            <div class="content-box">
                <h2>Contáctanos</h2>
                <p>Correo: admon.agronomex@gmail.com | Celular: (81)1229 3549</p>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <h3>AGRONO-MMERCE</h3>
            <p>© 2023 AGRONO-MMERCE. Todos los derechos reservados.</p>
            <!-- Ya eliminamos el botón rojo feo de aquí abajo -->
        </div>
    </footer>

    <script>
        function toggleNav() {
            var navLinks = document.getElementById("navLinks");
            navLinks.classList.toggle("show");
        }

        // Función para abrir/cerrar el menú desplegable del perfil
        function toggleUserMenu(event) {
            event.stopPropagation();
            var container = document.getElementById("userMenuContainer");
            container.classList.toggle("active");
        }

        // Cerrar el menú si se hace clic fuera de él
        window.addEventListener('click', function() {
            var container = document.getElementById("userMenuContainer");
            if (container && container.classList.contains('active')) {
                container.classList.remove('active');
            }
        });

        window.onload = function() {
            var popupMessage = document.getElementById("popupMessage");
            if (popupMessage) {
                popupMessage.classList.add("show");
                setTimeout(function() {
                    popupMessage.classList.add("hide");
                    setTimeout(function() { popupMessage.style.display = "none"; }, 500);
                }, 5000);
            }
        };
    </script>
</body>
</html>