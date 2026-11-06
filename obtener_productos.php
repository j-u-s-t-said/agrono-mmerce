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

// Configurar el encabezado para devolver XML
header('Content-Type: text/xml');

// Crear un objeto XML
$xml = new SimpleXMLElement('<productos/>');

// Consulta SQL
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $producto = $xml->addChild('producto');
        $producto->addChild('id', $row['id']);
        $producto->addChild('nombre', $row['nombre']);
        $producto->addChild('precio', $row['precio']);
        $producto->addChild('cantidad', $row['cantidad']);
        $producto->addChild('unidad', $row['unidad']);
    }
}

echo $xml->asXML();
$conn->close();
?>








