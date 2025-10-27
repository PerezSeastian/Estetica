<?php
session_start();
header('Content-Type: application/json');

// Verificar que el usuario esté logueado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

require_once 'database.php';


$id_mascota = $_POST['id_mascota'] ?? null;

if (!$id_mascota) {
    echo json_encode(['success' => false, 'message' => 'ID de mascota no proporcionado']);
    exit;
}

$conexion = conectarBD();


$sql_info = "SELECT nombre, foto FROM mascotas WHERE id_mascota = ?";
$stmt_info = $conexion->prepare($sql_info);
$stmt_info->bind_param("i", $id_mascota);
$stmt_info->execute();
$result_info = $stmt_info->get_result();

if ($result_info->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Mascota no encontrada']);
    exit;
}

$mascota = $result_info->fetch_assoc();
$nombre_mascota = $mascota['nombre'];
$foto_mascota = $mascota['foto'];


$id_usuario = $_SESSION['id_usuario'];
$sql_verificar = "SELECT id_mascota FROM mascotas WHERE id_mascota = ? AND id_usuario = ?";
$stmt_verificar = $conexion->prepare($sql_verificar);
$stmt_verificar->bind_param("ii", $id_mascota, $id_usuario);
$stmt_verificar->execute();
$result_verificar = $stmt_verificar->get_result();

if ($result_verificar->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'No tienes permiso para eliminar esta mascota']);
    exit;
}


if (!empty($foto_mascota) && file_exists("../uploads/mascotas/$foto_mascota")) {
    unlink("../uploads/mascotas/$foto_mascota");
}


$sql_eliminar = "DELETE FROM mascotas WHERE id_mascota = ?";
$stmt_eliminar = $conexion->prepare($sql_eliminar);
$stmt_eliminar->bind_param("i", $id_mascota);

if ($stmt_eliminar->execute()) {
    echo json_encode([
        'success' => true, 
        'message' => "Mascota '$nombre_mascota' eliminada correctamente"
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Error al eliminar la mascota: ' . $conexion->error
    ]);
}


$stmt_info->close();
$stmt_verificar->close();
$stmt_eliminar->close();
$conexion->close();
?>