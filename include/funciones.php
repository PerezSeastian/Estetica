<?php
require_once 'database.php';

function registrarUsuario($nombre, $telefono, $correo, $password, $direccion)
{
    $con = conectarBD();
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre_completo, telefono, correo, contrasena, direccion) 
            VALUES ('$nombre', '$telefono', '$correo', '$pass_hash', '$direccion')";

    if (mysqli_query($con, $sql)) {
        return ['success' => true, 'id' => mysqli_insert_id($con), 'message' => 'Registro exitoso!'];
    } else {
        return ['success' => false, 'message' => 'Error: ' . mysqli_error($con)];
    }
}

function correoExiste($correo)
{
    $con = conectarBD();
    $sql = "SELECT id_usuario FROM usuarios WHERE correo = '$correo'";
    $result = mysqli_query($con, $sql);
    return mysqli_num_rows($result) > 0;
}

function verificarLogin($correo, $password)
{
    $con = conectarBD();

    if ($correo == 'admin@gmail.com' && $password == 'admin123') {
        return ['success' => true, 'message' => 'Login admin exitoso', 'id_usuario' => 0, 'nombre' => 'Administrador', 'es_admin' => true];
    }

    $sql = "SELECT id_usuario, nombre_completo, contrasena FROM usuarios WHERE correo = '$correo'";
    $resultado = mysqli_query($con, $sql);

    if ($usuario = mysqli_fetch_assoc($resultado)) {
        if (password_verify($password, $usuario['contrasena'])) {
            return ['success' => true, 'message' => 'Login exitoso', 'id_usuario' => $usuario['id_usuario'], 'nombre' => $usuario['nombre_completo'], 'es_admin' => false];
        }
    }

    return ['success' => false, 'message' => 'Correo o contraseña incorrectos'];
}

function registrarMascota($id_usuario, $nombre, $especie, $raza, $edad)
{
    $con = conectarBD();
    $sql = "INSERT INTO mascotas (id_usuario, nombre, especie, raza, edad) 
            VALUES ('$id_usuario', '$nombre', '$especie', '$raza', '$edad')";

    if (mysqli_query($con, $sql)) {
        return ['success' => true, 'message' => '¡Mascota registrada correctamente!'];
    } else {
        return ['success' => false, 'message' => 'Error: ' . mysqli_error($con)];
    }

}
?>