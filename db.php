<?php
require_once 'config.php';

function conectar() {
    $conexion = new mysqli('localhost', '3867', 'caballo.fresno.llaves', '3867');

    if ($conexion->connect_error) {
        die('Error de conexión: ' . $conexion->connect_error);
    }

    return $conexion;
}

function desconectar($conexion) {
    $conexion->close();
}
?>