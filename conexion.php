<?php
require_once 'config.php';

$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

function desconectar($conexion) {
    $conexion->close();
}
?>
