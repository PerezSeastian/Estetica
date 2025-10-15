<?php
session_start();
require_once 'database.php';
$con = conectarBD();

$fecha = $_GET['fecha'] ?? '';

if (!$fecha) {
    echo json_encode([]);
    exit;
}

$query = "SELECT intervalos FROM horarios LIMIT 1";
$result = mysqli_query($con, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo json_encode([]);
    exit;
}

$row = mysqli_fetch_assoc($result);
$intervalos = json_decode($row['intervalos'], true) ?? [];

//  Consultar las citas ya ocupadas para esa fecha
$queryCitas = "SELECT hora FROM agenda WHERE fecha = STR_TO_DATE('$fecha', '%d/%m/%Y')";
$resCitas = mysqli_query($con, $queryCitas);

$ocupados = [];
while ($r = mysqli_fetch_assoc($resCitas)) {
    $ocupados[] = $r['hora'];
}

//  Marcar disponibilidad
foreach ($intervalos as &$i) {
    $i['disponible'] = !in_array($i['inicio'] . '-' . $i['fin'], $ocupados);
}

echo json_encode($intervalos);
