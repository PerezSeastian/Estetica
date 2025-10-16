<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

require_once 'database.php';
$conexion = conectarBD();

$id_usuario = $_GET['id'];

$sql_usuario = "SELECT id_usuario, nombre_completo, correo, telefono, direccion, estado 
                FROM usuarios WHERE id_usuario = $id_usuario";
$resultado_usuario = $conexion->query($sql_usuario);

if ($resultado_usuario && $resultado_usuario->num_rows > 0) {
    $usuario = $resultado_usuario->fetch_assoc();

    $sql_mascotas = "SELECT id_mascota, nombre, especie, raza, edad, foto, estado 
                     FROM mascotas 
                     WHERE id_usuario = $id_usuario 
                     ORDER BY nombre";
    $resultado_mascotas = $conexion->query($sql_mascotas);
    $mascotas = [];
    
    if ($resultado_mascotas && $resultado_mascotas->num_rows > 0) {
        while($mascota = $resultado_mascotas->fetch_assoc()) {
            $mascotas[] = $mascota;
        }
    }
    
    $usuario['mascotas'] = $mascotas;
    echo json_encode($usuario);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
}

$conexion->close();
?>