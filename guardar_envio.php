<?php
session_start();
include("conexion.php");

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["status" => "error", "message" => "No hay sesión activa"]);
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $nombre = mysqli_real_escape_string($conex, $data['nombre']);
    $direccion = mysqli_real_escape_string($conex, $data['direccion']);
    $colonia = mysqli_real_escape_string($conex, $data['colonia']);
    $cp = mysqli_real_escape_string($conex, $data['cp']);
    $ciudad = mysqli_real_escape_string($conex, $data['ciudad']);
    $estado = mysqli_real_escape_string($conex, $data['estado']);
    $telefono = mysqli_real_escape_string($conex, $data['telefono']);
    $correo = mysqli_real_escape_string($conex, $data['correo']);
    $notas = mysqli_real_escape_string($conex, $data['notas']);
    
    $req_factura = isset($data['req_factura']) ? intval($data['req_factura']) : 0;
    $rfc = $req_factura ? mysqli_real_escape_string($conex, $data['rfc']) : '';
    $razon_social = $req_factura ? mysqli_real_escape_string($conex, $data['razon_social']) : '';
    $uso_cfdi = $req_factura ? mysqli_real_escape_string($conex, $data['uso_cfdi']) : '';
    $regimen_fiscal = $req_factura ? mysqli_real_escape_string($conex, $data['regimen_fiscal']) : '';

    $sql = "INSERT INTO envios_facturas (usuario_id, nombre_destinatario, direccion, colonia, codigo_postal, ciudad, estado, telefono, correo, notas, requiere_factura, rfc, razon_social, uso_cfdi, regimen_fiscal) 
            VALUES ('$usuario_id', '$nombre', '$direccion', '$colonia', '$cp', '$ciudad', '$estado', '$telefono', '$correo', '$notas', '$req_factura', '$rfc', '$razon_social', '$uso_cfdi', '$regimen_fiscal')";

    if (mysqli_query($conex, $sql)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conex)]);
    }
}
$conex->close();
?>