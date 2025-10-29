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
$colonia = $_POST['colonia'] ?? '';
$codigo_postal = $_POST['codigo_postal'] ?? '';
$como_nos_conocio = $_POST['como_nos_conocio'] ?? '';

if ($nombre == '' || $email == '') {
    echo json_encode(['success' => false, 'message' => 'Nombre y email son obligatorios']);
    exit;
}

$conexion = conectarBD();

// Verificar si el email ya existe en otro usuario
$sql_check = "SELECT id_usuario FROM usuarios WHERE correo = '$email' AND id_usuario != $id_usuario";
$result_check = $conexion->query($sql_check);

if ($result_check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'El correo electrónico ya está en uso']);
    exit;
}

// Actualizar el perfil con los nuevos campos
$query = "UPDATE usuarios SET 
          nombre_completo = '$nombre', 
          correo = '$email', 
          telefono = '$telefono', 
          direccion = '$direccion',
          colonia = '$colonia',
          codigo_postal = '$codigo_postal',
          como_nos_conocio = '$como_nos_conocio' 
          WHERE id_usuario = $id_usuario";

if ($conexion->query($query)) {
    echo json_encode(['success' => true, 'message' => 'Perfil actualizado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . $conexion->error]);
}

$conexion->close();
?>