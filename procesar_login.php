<?php
session_start(); // Iniciar sesión de PHP

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registrarse";   // Tu base de datos actual

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$usuario = $_POST['username'];
$contrasena = $_POST['Password'];

$usuario = $conn->real_escape_string($usuario);
$contrasena = $conn->real_escape_string($contrasena);

$sql = "SELECT id, nombre_usuario FROM usuarios WHERE nombre_usuario='$usuario' AND contraseña='$contrasena'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Guardamos los datos del usuario en la sesión de PHP
    $_SESSION['usuario_id'] = $row['id'];
    $_SESSION['usuario'] = $row['nombre_usuario'];
    
    echo "success";
} else {
    echo "fail";
}

$conn->close();
?>





