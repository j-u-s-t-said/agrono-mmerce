<?php
session_start();
include("conexion.php");

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([]);
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$result = mysqli_query($conex, "SELECT producto_id as id, nombre, precio, cantidad, unidad FROM carrito WHERE usuario_id = '$usuario_id'");

$carrito = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $carrito[] = $row;
    }
}

echo json_encode($carrito);
?>