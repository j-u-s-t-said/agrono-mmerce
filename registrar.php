<?php
// Incluir el archivo de conexión
include("conexion.php");

// Función para validar los datos ingresados por el usuario
function validarDatos($usuario, $contrasena, $fecha_nacimiento, $correo, $telefono) 
{
    // Validaciones
    if (empty($usuario) || empty($contrasena) || empty($fecha_nacimiento) || empty($correo) || empty($telefono)) {
        return "Llena todos los campos";
    }
    if (!preg_match("/^[a-zA-Z0-9]+$/", $usuario)) {
        return "El nombre de usuario solo puede contener letras y números";
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        return "El formato del correo electrónico no es válido";
    }
    if (!preg_match("/^\d{10}$/", $telefono)) {
        return "El número de teléfono debe contener 10 dígitos";
    }
    return ""; // Sin errores
}

// Verificar si se envió el formulario de registro
if (isset($_POST['regist'])) {
    // Obtener y limpiar los datos del formulario
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);
    $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    
    // Validar los datos ingresados por el usuario
    $error = validarDatos($usuario, $contrasena, $fecha_nacimiento, $correo, $telefono);

    if ($error == "") {
        // Iniciar una transacción para garantizar la integridad de los datos
        mysqli_begin_transaction($conex);

        try {
            // Insertar en la tabla `usuarios`
            $consultaUsuario = "INSERT INTO usuarios(nombre_usuario, contraseña, fecha_nacimiento) VALUES('$usuario', '$contrasena', '$fecha_nacimiento')";
            if (!mysqli_query($conex, $consultaUsuario)) {
                throw new Exception("Error al insertar en la tabla usuarios: " . mysqli_error($conex));
            }

            // Obtener el ID del usuario recién insertado
            $idUsuario = mysqli_insert_id($conex);

            // Insertar en la tabla `contactos`
            $consultaContacto = "INSERT INTO contactos(usuario_id, correo, telefono) VALUES('$idUsuario', '$correo', '$telefono')";
            if (!mysqli_query($conex, $consultaContacto)) {
                throw new Exception("Error al insertar en la tabla contactos: " . mysqli_error($conex));
            }

            // Confirmar la transacción
            mysqli_commit($conex);

            // HTML de éxito
            ?>
            <html>
            <head>
                <title>Registro completado</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                    }
                    .container {
                        background-color: #fff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        text-align: center;
                    }
                    h3.success {
                        color: green;
                    }
                    a {
                        text-decoration: none;
                        color: #007BFF;
                        display: inline-block;
                        margin-top: 20px;
                    }
                    a:hover {
                        text-decoration: underline;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h3 class="success">Tu registro se ha completado</h3>
                    <a href="index.php">Volver a inicio de sesión</a>
                </div>
            </body>
            </html>
            <?php
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            mysqli_rollback($conex);
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo $error; // Mostrar mensaje de error de validación
    }
}
?>






