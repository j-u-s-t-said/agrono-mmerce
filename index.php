<?php
session_start();
// Opcional: Si quieres limpiar la sesión al entrar a la pantalla de login para asegurar el flujo de invitado:
// session_unset();
// session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"> <!-- Configura la codificación de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace que la página sea adaptable a dispositivos móviles -->
    <title>AGRONO-MMERCE 🌱</title> 
    <link rel="stylesheet" href="hojadeestiloslogin.css">
    <link rel="icon" href="Imagenes/WhatsApp_Image_2024-06-17_at_9.00.39_PM-removebg-preview.png"> <!-- Icono de la página -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> <!-- Carga los iconos como 'module' -->
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> <!-- Carga los iconos para navegadores antiguos -->
    <style>
        /* Estilo para el botón de volver al home para que combine con el diseño */
        .btn-home {
            width: 100%;
            height: 45px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            outline: none;
            border-radius: 40px;
            cursor: pointer;
            font-size: 16px;
            color: #fff;
            font-weight: 600;
            transition: background 0.3s ease;
            margin-top: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-home:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>

<div class="overlay"></div> <!-- Capa de color verde translúcido -->

<div class="wrapper">
    <h1>AGRONO-MMERCE</h1>

   

    <form name="login" id="loginForm"> <!-- Formulario de inicio de sesión -->
        <div class="input-box">
            <input name="username" id="username" type="text" placeholder="Ingrese su nombre de usuario" required> <!-- Campo de usuario -->
            <ion-icon name="person-sharp"></ion-icon> <!-- Icono de usuario -->
        </div>

        <div class="input-box">
            <input name="Password" id="password" type="password" placeholder="Ingrese su contraseña" required> <!-- Campo de contraseña -->
            <ion-icon name="lock-closed-sharp"></ion-icon> <!-- Icono de candado -->
            <ion-icon name="eye-outline" class="show-password" onclick="togglePasswordVisibility()"></ion-icon> <!-- Icono para mostrar/ocultar contraseña -->
        </div>

        <div class="remember-forgot">
            <label><input type="checkbox"> Recordarme</label> <!-- Opción para recordar al usuario -->
        </div>
        <div class="register-link">
            <p>¿No tienes cuenta?</p> 
            <a href="registrate1.php">Regístrate aquí</a> <!-- Enlace para registrarse -->
        </div>
        <button type="submit" class="btn">Login</button> <!-- Botón de inicio de sesión -->
        
        <!-- Botón para volver al home destruyendo sesión activa por seguridad -->
        <a href="cerrar_sesion_invitado.php" class="btn-home">Volver al Home</a>
    </form>
</div>


<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Evita que el formulario se envíe de forma tradicional
        let usuario = document.getElementById("username").value;
        let Password = document.getElementById("password").value;

        // Enviar datos al servidor mediante AJAX
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "procesar_login.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText.trim() === "success") {
                    window.location = "home.php"; // Redirige a la pagina principal si la autenticación es exitosa
                } else {
                    alert("Usuario o contraseña incorrectos"); // Muestra un mensaje de alerta si la autenticación falla
                }
            }
        };
        xhr.send("username=" + encodeURIComponent(usuario) + "&Password=" + encodeURIComponent(Password));
    });

    function togglePasswordVisibility() {
        let passwordField = document.getElementById("password"); // Campo de contraseña
        let eyeIcon = document.querySelector(".show-password"); // Icono de mostrar/ocultar contraseña

        if (passwordField.type === "password") {
            passwordField.type = "text"; // Muestra la contraseña
            eyeIcon.setAttribute("name", "eye-off-outline"); // Cambia el icono
        } else {
            passwordField.type = "password"; // Oculta la contraseña
            eyeIcon.setAttribute("name", "eye-outline"); // Cambia el icono
        }
    }

    document.oncontextmenu = function() {
        return false; // Deshabilita el menú contextual del clic derecho
    };
</script>

</body>
</html>