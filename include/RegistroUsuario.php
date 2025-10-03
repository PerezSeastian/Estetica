<?php
header('Content-Type: application/json');
session_start();
include 'database.php';
include 'funciones.php';

extract($_POST);

if (correoExiste($correo)) {
    die('{"success": false, "message": "Correo ya registrado"}');
}

$resultado = registrarUsuario($nombre, $telefono, $correo, $password, $direccion);

// Guardar ID si fue exitoso
if ($resultado['success']) {
    $con = conectarBD();
    $_SESSION['usuario_temporal'] = mysqli_insert_id($con);
    $_SESSION['usuario_nombre'] = $nombre;
    mysqli_close($con);
}
echo json_encode($resultado);
?>