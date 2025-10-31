<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

require_once 'database.php';
$conexion = conectarBD();

try {
    $mes = $_GET['mes'] ?? date('Y-m');
    
    if (!preg_match('/^\d{4}-\d{2}$/', $mes)) {
        throw new Exception('Formato de mes inválido. Use YYYY-MM');
    }
    $sql = "SELECT 
                a.servicio, 
                COUNT(a.id_cita) as total_citas
            FROM agenda a 
            WHERE DATE_FORMAT(a.fecha, '%Y-%m') = '$mes'
                AND a.estado NOT LIKE '%cancelada%'
                AND a.servicio IS NOT NULL 
                AND a.servicio != ''
            GROUP BY a.servicio
            ORDER BY total_citas DESC";

    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $servicios = [];
        while($fila = $resultado->fetch_assoc()) {
            $servicios[] = $fila;
        }
        echo json_encode($servicios);
    } else {
        echo json_encode([]);
    }

} catch (Exception $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
} finally {
    if (isset($conexion)) {
        $conexion->close();
    }
}
?>