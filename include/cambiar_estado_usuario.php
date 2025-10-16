<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

require_once 'database.php';

$data = json_decode(file_get_contents('php://input'), true);
$id_usuario = $data['id_usuario'];
$estado = $data['estado'];

$conexion = conectarBD();
$sql = "UPDATE usuarios SET estado = '$estado' WHERE id_usuario = $id_usuario";

if ($conexion->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Estado actualizado']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
}

$conexion->close();
?>