<?php
header('Content-Type: application/json');
session_start();
require_once 'database.php';

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$direccion = $_POST['direccion'] ?? '';

if ($nombre == '' || $email == '') {
    echo json_encode(['success' => false, 'message' => 'Nombre y email son obligatorios']);
    exit;
}

$conexion = conectarBD();
$query = "UPDATE usuarios SET nombre_completo = '$nombre', correo = '$email', telefono = '$telefono', direccion = '$direccion' WHERE id_usuario = $id_usuario";

if ($conexion->query($query)) {
    echo json_encode(['success' => true, 'message' => 'Perfil actualizado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
}

$conexion->close();
?>