<?php
session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

require_once 'conexion.php';

$idUsuario = $_SESSION['idUsuario'];
$message = '';

$query = "SELECT * FROM webs WHERE idUsuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
$webs = $result->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['crear_web'])) {
    $nombre_web = $_POST['nombre_web'];
    $proyecto = $nombre_web . $idUsuario;

    $query = "SELECT * FROM webs WHERE dominio = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $proyecto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "El dominio ya existe. Por favor, elige otro nombre para tu web.";
    } else {
        $query = "INSERT INTO webs (dominio, idUsuario) VALUES (?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("si", $proyecto, $idUsuario);

        if ($stmt->execute()) {
            $line = "./wix.sh $proyecto $proyecto";
            $script_output = shell_exec($line);
            var_dump($script_output);
            $message = "Web creada exitosamente. Dominio: $proyecto";
        } else {
            $message = "Error al crear la web. Por favor, inténtalo nuevamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a tu panel</title>
    <style type="text/css">
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
        margin-top: 20px;
    }

    p {
        text-align: center;
    }

    .success-message {
        text-align: center;
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        margin: 10px auto;
        max-width: 400px;
        border-radius: 5px;
    }

    form {
        text-align: center;
        max-width: 400px;
        margin: 0 auto;
    }

    label {
        display: block;
        margin-top: 20px;
        font-weight: bold;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #0078d4;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 20px;
    }

    input[type="submit"]:hover {
        background-color: #005499;
    }

    h2 {
        text-align: center;
        margin-top: 20px;
    }

    ul {
        list-style: none;
        padding: 0;
        text-align: center;
    }

    li {
        margin-top: 10px;
    }

    a {
        color: #0078d4;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
    .red{
        color: red;
    }
</style>
</head>
<body>
    <h1>Bienvenido a tu panel</h1>
    <p><a href="logout.php" class="red">Cerrar sesión de <?php echo $idUsuario; ?></a></p>
    <?php if (!empty($message)) { ?>
        <div class="success-message">
            <p><?php echo $message; ?></p>
        </div>
    <?php } ?>
    <form action="panel.php" method="POST">
        <label for="nombre_web">Generar Web de:</label>
        <input type="text" id="nombre_web" name="nombre_web" placeholder="Nombre de la nueva web">
        <input type="submit" name="crear_web" value="Crear web">
    </form>
    <h2>Tus Webs:</h2>
    <ul>
        <?php foreach ($webs as $web) { ?>
            <li><a href="<?php echo $web['dominio']; ?>/index.php"><?php echo $web['dominio']; ?></a></li>
        <?php } ?>
    </ul>
</body>
</html>
