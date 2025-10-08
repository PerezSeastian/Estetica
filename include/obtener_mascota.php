<?php
header('Content-Type: application/json');
session_start();
require_once 'database.php';

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$id_mascota = $_GET['id'] ?? 0;
$id_usuario = $_SESSION['id_usuario'];

$conexion = conectarBD();
$sql = "SELECT id_mascota, nombre, especie, raza, edad, foto FROM mascotas WHERE id_mascota = $id_mascota AND id_usuario = $id_usuario";
$resultado = $conexion->query($sql);

if ($mascota = $resultado->fetch_assoc()) {
    echo json_encode(['success' => true, 'mascota' => $mascota]);
} else {
    echo json_encode(['success' => false, 'message' => 'Mascota no encontrada']);
}

$conexion->close();
?>