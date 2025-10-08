<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([]);
    exit;
}

$con = conectarBD();
$id_usuario = $_SESSION['id_usuario'];

$result = mysqli_query($con, "SELECT id_mascota, nombre FROM mascotas WHERE id_usuario = '$id_usuario'");
$mascotas = [];

while ($row = mysqli_fetch_assoc($result)) {
    $mascotas[] = $row;
}

echo json_encode($mascotas);
mysqli_close($con);
?>
