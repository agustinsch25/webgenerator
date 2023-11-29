<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: principal.php');
    exit();
}

session_unset();
session_destroy();
header('Location: principal.php');
exit();
?>