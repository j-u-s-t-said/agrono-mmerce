<?php

// Conexión a la base de datos
$servername = "localhost";
$username = "root";       
$password = "";       
$dbname = "registro_productos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del XML
$data = simplexml_load_string(file_get_contents('php://input'));

$nombre = $conn->real_escape_string($data->nombre);
$precio = $conn->real_escape_string($data->precio);
$cantidad = $conn->real_escape_string($data->cantidad);
$unidad = $conn->real_escape_string($data->unidad);

// Insertar producto en la base de datos
$sql = "INSERT INTO productos (nombre, precio, cantidad, unidad) VALUES ('$nombre', '$precio', '$cantidad', '$unidad')";

header('Content-Type: text/xml');
$response = new SimpleXMLElement('<response/>');

if ($conn->query($sql) === TRUE) {
    $response->addChild('success', 'true');
} else {
    $response->addChild('success', 'false');
    $response->addChild('message', $conn->error);
}

echo $response->asXML();
$conn->close();
?>

