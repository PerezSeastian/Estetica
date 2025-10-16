<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No hay usuario en sesión']);
    exit;
}

$con = conectarBD();

$id_usuario = $_SESSION['id_usuario'];
$id_mascota = $_POST['mascota'] ?? '';
$fecha = $_POST['fecha'] ?? '';
$hora = $_POST['hora'] ?? '';
$sucursal = $_POST['sucursal'] ?? '';
$servicio = $_POST['servicio'] ?? '';
$taxi_perruno = $_POST['taxi_perruno'] ?? '';

if (empty($id_mascota) || empty($fecha) || empty($hora) || empty($sucursal) || empty($servicio) || empty($taxi_perruno)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    exit;
}

$sql = "INSERT INTO agenda (id_usuario, id_mascota, fecha, hora, sucursal, servicio, taxi_perruno)
        VALUES ('$id_usuario', '$id_mascota', STR_TO_DATE('$fecha', '%d/%m/%Y'), '$hora', '$sucursal', '$servicio', '$taxi_perruno')";

if (mysqli_query($con, $sql)) {
    echo json_encode(['success' => true, 'message' => 'En unas horas te confirmamos tu cita vía WhatsApp 📱']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . mysqli_error($con)]);
}

mysqli_close($con);
?>
