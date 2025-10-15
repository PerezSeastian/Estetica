<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

require_once 'database.php';

$id_usuario = $_POST['id_usuario'] ?? '';
$conexion = conectarBD();

// Datos del usuario
$usuario = $conexion->query("SELECT * FROM usuarios WHERE id_usuario = $id_usuario")->fetch_assoc();

// Mascotas del usuario
$mascotas = $conexion->query("SELECT * FROM mascotas WHERE id_usuario = $id_usuario")->fetch_all(MYSQLI_ASSOC);

if ($usuario) {
    echo json_encode([
        'success' => true,
        'usuario' => $usuario,
        'mascotas' => $mascotas
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
}

$conexion->close();
?>