<?php
require_once 'database.php';
$con = conectarBD();

$input = json_decode(file_get_contents("php://input"), true);
$sucursal = $input['sucursal'] ?? 0;
$apertura = $input['apertura'] ?? '';
$cierre = $input['cierre'] ?? '';
$intervalos = $input['intervalos'] ?? [];

if (!$sucursal || !$apertura || !$cierre) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}

$intervalos_json = json_encode($intervalos);

$query = "INSERT INTO horarios (id_sucursal, hora_apertura, hora_cierre, intervalos)
          VALUES ('$sucursal', '$apertura', '$cierre', '$intervalos_json')
          ON DUPLICATE KEY UPDATE 
          hora_apertura='$apertura', hora_cierre='$cierre', intervalos='$intervalos_json'";

if (mysqli_query($con, $query)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => mysqli_error($con)]);
}
?>
