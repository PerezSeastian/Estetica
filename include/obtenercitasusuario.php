<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

require_once 'database.php';

$id_usuario = $_SESSION['id_usuario'];
$conexion = conectarBD();

// Consulta CORREGIDA - usando los nombres correctos de tu tabla
$sql = "SELECT 
            a.id_cita, 
            m.nombre as nombre_mascota, 
            a.fecha, 
            a.hora, 
            a.estado, 
            a.servicio,
            a.sucursal
        FROM agenda a 
        JOIN mascotas m ON a.id_mascota = m.id_mascota 
        WHERE a.id_usuario = $id_usuario 
        ORDER BY a.fecha DESC, a.hora DESC";

$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    $citas = [];
    while($fila = $resultado->fetch_assoc()) {
        $citas[] = $fila;
    }
    echo json_encode($citas);
} else {
    echo json_encode([]);
}

$conexion->close();
?>