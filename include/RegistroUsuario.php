<?php
header('Content-Type: application/json');
session_start();
include 'database.php';
include 'funciones.php';

if (!isset($_POST['correo']) || !isset($_POST['password'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
    exit;
}

$nombre = $_POST['nombre'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$correo = $_POST['correo'] ?? '';
$password = $_POST['password'] ?? '';
$direccion = $_POST['direccion'] ?? '';

if ($correo == '' || $password == '') {
    echo json_encode(['success' => false, 'message' => 'Correo y contraseña son obligatorios']);
    exit;
}

if (correoExiste($correo)) {
    echo json_encode(['success' => false, 'message' => 'Correo ya registrado']);
    exit;
}

$resultado = registrarUsuario($nombre, $telefono, $correo, $password, $direccion);

if ($resultado['success']) {
    $_SESSION['usuario_temporal'] = $resultado['id'];
    $_SESSION['usuario_nombre'] = $nombre;
    echo json_encode(['success' => true, 'message' => 'Usuario registrado', 'redirect' => 'registroM.html']);
} else {
    echo json_encode($resultado);
}
?>