<?php
header('Content-Type: application/json');
session_start();
include 'database.php';
include 'funciones.php';

// Recibir datos
$correo = $_POST['correo'];
$password = $_POST['password'];

// Usar la función de funciones.php
$resultado = verificarLogin($correo, $password);

// Si es exitoso, guardar en sesión
if ($resultado['success']) {
    $_SESSION['id_usuario'] = $resultado['id_usuario'];
    $_SESSION['nombre_usuario'] = $resultado['nombre'];
    $_SESSION['loggedin'] = true;
}

echo json_encode($resultado);
?>