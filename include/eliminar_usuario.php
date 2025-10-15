<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

require_once 'database.php';

$id_usuario = $_POST['id_usuario'] ?? '';

if (empty($id_usuario)) {
    echo json_encode(['success' => false, 'message' => 'ID de usuario requerido']);
    exit;
}

$conexion = conectarBD();


$conexion->query("DELETE FROM mascotas WHERE id_usuario = $id_usuario");

if ($conexion->query("DELETE FROM usuarios WHERE id_usuario = $id_usuario")) {
    echo json_encode(['success' => true, 'message' => 'Usuario y sus mascotas eliminados']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar']);
}

$conexion->close();
?>