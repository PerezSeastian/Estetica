<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

require_once 'database.php';

$id_usuario = $_SESSION['id_usuario'];
$nombre = $_POST['nombre'];
$especie = $_POST['especie'];
$raza = $_POST['raza'];
$edad = $_POST['edad'];
$editId = $_POST['editId'];

if (empty($nombre) || empty($especie) || empty($_FILES['foto']['name'])) {
    echo json_encode(['success' => false, 'message' => 'Nombre, especie y foto son obligatorios']);
    exit;
}

$conexion = conectarBD();
$foto = $_FILES['foto'];

if ($foto['type'] != 'image/jpeg' && $foto['type'] != 'image/png' && $foto['type'] != 'image/gif') {
    echo json_encode(['success' => false, 'message' => 'Solo se permiten imágenes JPG, PNG o GIF']);
    exit;
}

$extension = pathinfo($foto['name'], PATHINFO_EXTENSION);
$foto_nombre = uniqid() . '.' . $extension;

if (!is_dir('../uploads/mascotas')) {
    mkdir('../uploads/mascotas', 0777, true);
}

move_uploaded_file($foto['tmp_name'], "../uploads/mascotas/$foto_nombre");

if (!empty($editId)) {
    $foto_anterior = $conexion->query("SELECT foto FROM mascotas WHERE id_mascota = $editId")->fetch_assoc()['foto'];
    if (!empty($foto_anterior) && file_exists("../uploads/mascotas/$foto_anterior")) {
        unlink("../uploads/mascotas/$foto_anterior");
    }
    $sql = "UPDATE mascotas SET nombre = '$nombre', especie = '$especie', raza = '$raza', edad = '$edad', foto = '$foto_nombre' WHERE id_mascota = $editId AND id_usuario = $id_usuario";
    $mensaje = 'Mascota actualizada';
} else {
    $sql = "INSERT INTO mascotas (id_usuario, nombre, especie, raza, edad, foto) VALUES ($id_usuario, '$nombre', '$especie', '$raza', '$edad', '$foto_nombre')";
    $mensaje = 'Mascota registrada';
}

if ($conexion->query($sql)) {
    echo json_encode(['success' => true, 'message' => $mensaje]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar']);
}

$conexion->close();
?>