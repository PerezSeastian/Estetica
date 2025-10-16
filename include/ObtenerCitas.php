<?php
require_once 'database.php';
$con = conectarBD();

// Fecha filtrada (por defecto hoy)
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

// Convertir formato si llega tipo d/m/Y
if (strpos($fecha, '/') !== false) {
    $partes = explode('/', $fecha);
    $fecha = "{$partes[2]}-{$partes[1]}-{$partes[0]}";
}

$sql = "SELECT 
    a.id_cita,
    m.nombre AS nombre_mascota,
    u.nombre_completo AS nombre_cliente,
    u.telefono,
    a.sucursal,
    a.servicio,
    a.hora,
    a.fecha,
    a.estado,
    a.taxi_perruno
FROM agenda a
JOIN mascotas m ON a.id_mascota = m.id_mascota
JOIN usuarios u ON a.id_usuario = u.id_usuario
 WHERE DATE(a.fecha) = '$fecha'
ORDER BY a.hora ASC
";



$result = mysqli_query($con, $sql);

$citas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $citas[] = $row;
}

header('Content-Type: application/json');
echo json_encode($citas);
mysqli_close($con);
?>
