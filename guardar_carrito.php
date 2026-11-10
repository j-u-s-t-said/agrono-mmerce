<?php
session_start();
include("conexion.php"); // Utiliza la variable $conex de tu conexion.php

if (!isset($_SESSION['usuario_id'])) {
    echo "no_session";
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['carrito'])) {
    // Borrar carrito anterior para actualizar con la lista actual del usuario
    mysqli_query($conex, "DELETE FROM carrito WHERE usuario_id = '$usuario_id'");

    foreach ($data['carrito'] as $item) {
        $id = mysqli_real_escape_string($conex, $item['id']);
        $nombre = mysqli_real_escape_string($conex, $item['nombre']);
        $precio = floatval($item['precio']);
        $cantidad = intval($item['cantidad']);
        $unidad = mysqli_real_escape_string($conex, $item['unidad']);

        $sql = "INSERT INTO carrito (usuario_id, producto_id, nombre, precio, cantidad, unidad) 
                VALUES ('$usuario_id', '$id', '$nombre', '$precio', '$cantidad', '$unidad')";
        mysqli_query($conex, $sql);
    }
    echo "success";
}
?>