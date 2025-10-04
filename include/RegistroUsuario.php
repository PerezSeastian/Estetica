<?php
header('Content-Type: application/json');
session_start();
include 'database.php';
include 'funciones.php';

extract($_POST);

if (correoExiste($correo)) {
    die(json_encode(['success' => false, 'message' => 'Correo ya registrado']));
}

$resultado = registrarUsuario($nombre, $telefono, $correo, $password, $direccion);

if ($resultado['success']) {
    $_SESSION['usuario_temporal'] = $resultado['id']; // guardamos el id real
    $_SESSION['usuario_nombre'] = $nombre;
    echo json_encode(['success' => true, 'message' => 'Usuario registrado', 'redirect' => 'registroM.html']);
} else {
    echo json_encode($resultado);
}
