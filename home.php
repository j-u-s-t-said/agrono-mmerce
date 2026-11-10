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
    <title>AGRONO-MMERCE</title>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="home_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="Imagenes/WhatsApp_Image_2024-06-17_at_9.00.39_PM-removebg-preview.png"> 
    <style>
        /* Estilo para alinear el perfil junto al logo */
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
        /* Corrección para evitar que el footer se sobreponga */
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
    <div id="popupMessage" class="popup-message">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></div>

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
                        <li><a href="product4.html">Resin Oil </a></li>
                    </ul>
                </li>
                <li><a href="recibo.php">Compras</a></li>
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
            <button onclick="location.href='logout.php'" class="logout">Salir</button>
        </div>
    </footer>
    <script>
        function toggleNav() {
            var navLinks = document.getElementById("navLinks");
            navLinks.classList.toggle("show");
        }
        window.onload = function() {
            var popupMessage = document.getElementById("popupMessage");
            popupMessage.classList.add("show");
            setTimeout(function() {
                popupMessage.classList.add("hide");
                setTimeout(function() { popupMessage.style.display = "none"; }, 500);
            }, 5000);
        };
    </script>
</body>
</html>