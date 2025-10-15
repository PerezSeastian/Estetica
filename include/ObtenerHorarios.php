<?php
require_once 'database.php';
$con = conectarBD();

$sucursal = $_GET['sucursal'] ?? 0;

$result = mysqli_query($con, "SELECT * FROM horarios WHERE id_sucursal = '$sucursal'");
$data = mysqli_fetch_assoc($result);

if ($data) {
    $data['intervalos'] = json_decode($data['intervalos'], true);
    echo json_encode($data);
} else {
    echo json_encode(null);
}
?>
