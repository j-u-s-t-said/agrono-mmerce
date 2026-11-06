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

$id = $conn->real_escape_string($data->id);

// Eliminar producto de la base de datos
$sql = "DELETE FROM productos WHERE id = '$id'";

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




