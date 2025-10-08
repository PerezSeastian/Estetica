<?php
header('Content-Type: application/json');
session_start();
include 'database.php';
include 'funciones.php';

$correo = $_POST['correo'];
$password = $_POST['password'];

$resultado = verificarLogin($correo, $password);

if ($resultado['success']) {
    $_SESSION['id_usuario'] = $resultado['id_usuario'];
    $_SESSION['nombre_usuario'] = $resultado['nombre'];
    $_SESSION['loggedin'] = true;
    $_SESSION['es_admin'] = $resultado['es_admin'];
}

echo json_encode($resultado);
?>