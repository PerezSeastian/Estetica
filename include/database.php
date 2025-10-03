<?php

function conectarBD() {
    $usuario = "root";
    $password = "";
    $database = "estetica";
    $host = "127.0.0.1";

    $con = mysqli_connect($host, $usuario, $password, $database);

    if (!$con) {
        die("Fallo la conexión: " . mysqli_connect_error());
    }
    return $con;
}
?>
