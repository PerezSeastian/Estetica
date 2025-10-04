<?php
header('Content-Type: application/json');
session_start();
include 'database.php';
include 'funciones.php';

if (!isset($_SESSION['usuario_temporal'])) {
    echo json_encode(['success' => false, 'message' => 'No hay usuario en sesión']);
    exit;
}

$id_usuario = $_SESSION['usuario_temporal'];
$nombre = $_POST['nombre'] ?? '';
$especie = $_POST['especie'] ?? '';
$raza = $_POST['raza'] ?? '';
$edad = $_POST['edad'] ?? '';

if ($nombre == '' || $especie == '') {
    echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
    exit;
}

$resultado = registrarMascota($id_usuario, $nombre, $especie, $raza, $edad);

if ($resultado['success']) {
    echo json_encode(['success' => true, 'message' => 'Mascota registrada correctamente!']);
} else {
    echo json_encode($resultado);
}
?>