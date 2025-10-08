<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    echo json_encode(['success' => false, 'message' => 'No tienes permisos']);
    exit;
}
require_once 'database.php';

$id_mascota = $_POST['id_mascota'];
$id_usuario = $_SESSION['id_usuario'];

if (empty($id_mascota)) {
    echo json_encode(['success' => false, 'message' => 'No se recibió el ID de la mascota']);
    exit;
}

$conexion = conectarBD();

$consulta_foto = "SELECT foto FROM mascotas WHERE id_mascota = $id_mascota AND id_usuario = $id_usuario";
$resultado = $conexion->query($consulta_foto);
$datos_mascota = $resultado->fetch_assoc();

$eliminar = "DELETE FROM mascotas WHERE id_mascota = $id_mascota AND id_usuario = $id_usuario";
if ($conexion->query($eliminar)) {
    if (!empty($datos_mascota['foto'])) {
        $ruta_foto = "../uploads/mascotas/" . $datos_mascota['foto'];
        if (file_exists($ruta_foto)) {
            unlink($ruta_foto);
        }
    }
    echo json_encode(['success' => true, 'message' => 'Mascota eliminada correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'No se pudo eliminar la mascota']);
}
$conexion->close();


?>