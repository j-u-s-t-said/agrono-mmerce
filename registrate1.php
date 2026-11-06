<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registro 🌱</title>
    <!-- Enlace al archivo de estilos CSS externo -->
    <link rel="stylesheet" type="text/css" href="style_regis.css">
    <link rel="icon" href="Imagenes/WhatsApp_Image_2024-06-17_at_9.00.39_PM-removebg-preview.png"> 
    <style>
        /* Estilos CSS internos para la clase .error */
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
    <script>
        // Función JavaScript para validar el formulario antes de enviarlo
        function validateForm() {
            // Obtener valores de los campos del formulario
            let usuario = document.forms["registro"]["usuario"].value;
            let contrasena = document.forms["registro"]["contrasena"].value;
            let fecha_nacimiento = document.forms["registro"]["fecha_nacimiento"].value;
            let correo = document.forms["registro"]["correo"].value;
            let telefono = document.forms["registro"]["telefono"].value;
            let errorMessage = "";

            // Validar campos vacíos
            if (usuario == "" || contrasena == "" || fecha_nacimiento == "" || correo == "" || telefono == "") {
                errorMessage = "Llena todos los campos";
            }
            // Validar caracteres no permitidos en el nombre de usuario
            else if (!/^[a-zA-Z0-9]+$/.test(usuario)) {
                errorMessage = "El nombre de usuario solo puede contener letras y números";
            }
            // Validar formato de correo electrónico
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) {
                errorMessage = "El formato del correo electrónico no es válido";
            }
            // Validar formato de número de teléfono
            else if (!/^\d{10}$/.test(telefono)) {
                errorMessage = "El número de teléfono debe contener 10 dígitos";
            }

            // Mostrar mensaje de error si hay algún error encontrado
            if (errorMessage != "") {
                document.getElementById("error-message").innerText = errorMessage;
                return false; // Evita el envío del formulario si hay errores
            } else {
                return true; // Permite el envío del formulario si no hay errores
            }
        }
    </script>
</head>
<body>
    <div class="overlay">
        <div class="registro">
        <!-- Formulario de registro que envía datos a 'registrar.php' usando POST y valida con 'validateForm()' -->
        <form name="registro" action="registrar.php" method="post" onsubmit="return validateForm()"> 
                <h1>Registro</h1>

                <div class="usuario">
                    <label for="usuario">Usuario:</label>
                    <input type="text" name="usuario">
                </div>

                <div class="contraseña">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" name="contrasena">
                </div>

                <div class="fechanac">
                    <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                    <input type="date" name="fecha_nacimiento">
                </div>

                <div class="correo">
                    <label for="correo">Correo electrónico:</label>
                    <input type="email" name="correo">
                </div>

                <div class="numero">
                    <label for="telefono">Número de teléfono:</label>
                    <input type="text" name="telefono">
                </div>

                <div class="regis">
                    <input name="regist" type="submit" value="Registrarse">
                </div>

                <div class="volver">
                    <a href="index.php">Volver a inicio de sesion</a>
                </div>

                <div id="error-message" class="error"></div>
            </form>
        </div>
    </div>
</body>
</html>


