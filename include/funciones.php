<?php
require_once 'database.php';

function registrarUsuario($nombre, $telefono, $correo, $password, $direccion)
{
    $con = conectarBD();
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Usuarios (nombre_completo, telefono, correo, contrasena, direccion) 
            VALUES ('$nombre', '$telefono', '$correo', '$pass_hash', '$direccion')";

    if (mysqli_query($con, $sql)) {
        return ['success' => true, 'message' => 'Registro exitoso!'];
    } else {
        return ['success' => false, 'message' => 'Error: ' . mysqli_error($con)];
    }
}

function correoExiste($correo)
{
    $con = conectarBD();
    $sql = "SELECT id_usuario FROM Usuarios WHERE correo = '$correo'";
    $result = mysqli_query($con, $sql);
    return mysqli_num_rows($result) > 0;
}

function verificarLogin($correo, $password)
{
    $con = conectarBD();

    $sql = "SELECT id_usuario, nombre_completo, contrasena FROM Usuarios WHERE correo = '$correo'";
    $result = mysqli_query($con, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verificar contraseña
        if (password_verify($password, $row['contrasena'])) {
            return [
                'success' => true,
                'message' => 'Login exitoso',
                'id_usuario' => $row['id_usuario'],
                'nombre' => $row['nombre_completo']
            ];
        }
    }

    return ['success' => false, 'message' => 'Correo o contraseña incorrectos'];
}
?>