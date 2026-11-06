<?php
// Detalles de la conexión a la base de datos
$servername = "localhost"; // Nombre del servidor de la base de datos
$username = "root";        // Nombre de usuario de la base de datos
$password = "";            // Contraseña de la base de datos, en este caso, es nula por defecto
$dbname = "registrarse";   // Nombre de la base de datos a la que conectarse

// Crear conexión a la base de datos utilizando MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error); // Si hay un error de conexión, muestra un mensaje y termina el script
}

// Obtener datos del usuario desde un formulario POST
$usuario = $_POST['username'];     // Obtener el nombre de usuario desde el formulario
$contrasena = $_POST['Password'];  // Obtener la contraseña desde el formulario

// Sanitizar (limpiar) la entrada para evitar ataques de inyección SQL
$usuario = $conn->real_escape_string($usuario);       // Escapar caracteres especiales en el nombre de usuario
$contrasena = $conn->real_escape_string($contrasena); // Escapar caracteres especiales en la contraseña

// Consulta SQL para verificar si el usuario y contraseña existen en la tabla usuarios
$sql = "SELECT id FROM usuarios WHERE nombre_usuario='$usuario' AND contraseña='$contrasena'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "success";
} else {
    echo "fail";
}


$conn->close(); // Cerrar la conexión a la base de datos al finalizar el script
?>






