<?php
require_once 'database.php';
$con = conectarBD();

header('Content-Type: application/json');


$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !is_array($input)) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
    exit;
}

$stmt = $con->prepare("UPDATE agenda SET estado = ? WHERE id_cita = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta.']);
    exit;
}

foreach ($input as $id_cita => $estado) {
    $stmt->bind_param("si", $estado, $id_cita);
    $stmt->execute();
}

$stmt->close();
$con->close();

echo json_encode(['success' => true, 'message' => 'Estados actualizados correctamente.']);
?>
