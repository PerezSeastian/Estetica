<?php

function conectarBD() {
    $usuario = "u191445427_sistestetica";
    $password = "Estetica+2025";
    $database = " u191445427_sistestetica";
    $host = "rv654.hstgr.io";

    $con = mysqli_connect($host, $usuario, $password, $database);

    if (!$con) {
        die("Fallo la conexión: " . mysqli_connect_error());
    }
    return $con;
}
?>
