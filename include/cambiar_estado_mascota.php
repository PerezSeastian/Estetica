<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'No tienes permiso para hacer esto']);
    exit;
}

require_once 'database.php';

$input = json_decode(file_get_contents('php://input'), true);
$id_mascota = $input['id_mascota'];
$nuevo_estado = $input['estado'];

$conexion = conectarBD();

$estados_permitidos = ['activo', 'fallecido', 'cambio_peluqueria', 'cambio_casa', 'cambio_ciudad', 'abandono_estetica', 'abandonado'];

if (!in_array($nuevo_estado, $estados_permitidos)) {
    echo json_encode(['success' => false, 'message' => 'Este estado no está permitido']);
    exit;
}

$sql = "UPDATE mascotas SET estado = '$nuevo_estado' WHERE id_mascota = $id_mascota";

if ($conexion->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Estado de la mascota actualizado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar en la base de datos: ' . $conexion->error]);
}

$conexion->close();
?>