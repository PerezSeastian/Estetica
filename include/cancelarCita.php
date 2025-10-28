<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'No tienes permiso']);
    exit;
}

require_once 'database.php';

$input = file_get_contents('php://input');
$data = json_decode($input, true);
$id_cita = $data['id_cita'];
$id_usuario = $_SESSION['id_usuario'];

$conexion = conectarBD();

$sql = "SELECT id_cita FROM agenda WHERE id_cita = $id_cita AND id_usuario = $id_usuario AND estado = 'pendiente'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'No se puede cancelar esta cita']);
    exit;
}


$sql_update = "UPDATE agenda SET estado = 'cancelada' WHERE id_cita = $id_cita";

if ($conexion->query($sql_update)) {
    echo json_encode(['success' => true, 'message' => 'Cita cancelada correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al cancelar']);
}

$conexion->close();
?>