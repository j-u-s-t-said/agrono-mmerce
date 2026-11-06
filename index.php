<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"> <!-- Configura la codificación de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace que la página sea adaptable a dispositivos móviles -->
    <title>AGRONOMEX 🌱</title> 
    <link rel="stylesheet" href="hojadeestiloslogin.css">
    <link rel="icon" href="Imagenes/WhatsApp_Image_2024-06-17_at_9.00.39_PM-removebg-preview.png"> <!-- Icono de la página -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> <!-- Carga los iconos como 'module' -->
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> <!-- Carga los iconos para navegadores antiguos -->
</head>
<body onload="mueveReloj()"> <!-- Ejecuta la función mueveReloj() al cargar la página -->

<div class="overlay"></div> <!-- Capa de color verde translúcido -->

<div class="wrapper">
    <h1>AGRONOMEX</h1>

    <div class="visit-counter">
        <?php
            $archivo = 'contador.txt'; // asigna el nombre del archivo 'contador.txt' a la variable $archivo, que se utiliza para guardar el número de visitas
            if(file_exists($archivo)){
                $contador = file_get_contents($archivo); // Lee el número actual de visitas
                $contador++; // cada vez que ingresemos a la pagina el contador de visitas se incrementara en 1
            } else {
                $contador = 1; // Inicializa el contador si no existe el archivo
            }
            file_put_contents($archivo, $contador); // Guarda el nuevo número de visitas
            echo "Número de visitas: ". $contador . " veces."; // Muestra el número de visitas
        ?>
    </div>

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
    </form>
</div>

<div class="reloj">
    <h2>HORA REAL:</h2> <!-- Título de la sección de la hora -->
    <form name="form_reloj">
        <input type="text" name="reloj" size="10" style="background-color: transparent; color: #fff; font-family: Verdana, Arial, Helvetica; font-size: 25px; text-align: left;" readonly> <!-- Campo para mostrar la hora actual -->
    </form>
</div>

<script>
    function mueveReloj() {
        let momentoActual = new Date(); // Obtiene la fecha y hora actual
        let hora = momentoActual.getHours(); // Obtiene la hora actual
        let minuto = momentoActual.getMinutes(); // Obtiene los minutos actuales
        let segundo = momentoActual.getSeconds(); // Obtiene los segundos actuales

        if (segundo < 10) segundo = "0" + segundo; // Añade un cero delante si es necesario
        if (minuto < 10) minuto = "0" + minuto; // Añade un cero delante si es necesario
        if (hora < 10) hora = "0" + hora; // Añade un cero delante si es necesario

        let horaImprimible = hora + " : " + minuto + " : " + segundo; // Formatea la hora para mostrarla
        document.forms['form_reloj'].elements['reloj'].value = horaImprimible; // Muestra la hora en el campo correspondiente

        setTimeout(mueveReloj, 1000); // Actualiza la hora cada segundo
    }

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
                    window.location = "home.html"; // Redirige a la pagina principal si la autenticación es exitosa
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
