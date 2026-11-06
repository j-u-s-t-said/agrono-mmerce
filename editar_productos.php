<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";       
$password = "";       
$dbname = "registro_productos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se recibió el contenido de la solicitud
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el XML enviado en la solicitud
    $xml_data = file_get_contents("php://input");
    
    // Cargar el XML y verificar si es válido
    $xml = simplexml_load_string($xml_data);
    
    if ($xml === false) {
        echo "<success>false</success><error>Error al analizar el XML</error>";
        exit();
    }

    // Extraer los datos del producto desde el XML
    $id = $xml->id;
    $nombre = $xml->nombre;
    $precio = $xml->precio;
    $cantidad = $xml->cantidad;
    $unidad = $xml->unidad;

    // Validar que se hayan recibido todos los campos necesarios
    if (empty($id) || empty($nombre) || empty($precio) || empty($cantidad) || empty($unidad)) {
        echo "<success>false</success><error>Datos incompletos</error>";
        exit();
    }

    // Preparar la sentencia SQL para actualizar el producto
    $stmt = $conn->prepare("UPDATE productos SET nombre = ?, precio = ?, cantidad = ?, unidad = ? WHERE id = ?");
    $stmt->bind_param("sdisi", $nombre, $precio, $cantidad, $unidad, $id); // s: string, d: double, i: integer

    // Ejecutar la sentencia y verificar si fue exitosa
    if ($stmt->execute()) {
        echo "<success>true</success>";
    } else {
        echo "<success>false</success><error>Error al actualizar el producto</error>";
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "<success>false</success><error>Método no permitido</error>";
}
?>

