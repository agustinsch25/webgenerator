<?php
require_once 'conexion.php';

if (isset($_POST['login'])) {
    $email = $_POST['username'];
    $password = $_POST['password'];
    if (empty($email)) {
        $error = "Por favor, ingresa tu email.";
    } elseif (empty($password)) {
        $error = "Por favor, ingresa tu contraseña.";
    } else {
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $usuario = $result->fetch_assoc();

            // Verifica la contraseña utilizando password_verify
            if (password_verify($password, $usuario['password'])) {
                session_start();
                $_SESSION['idUsuario'] = $usuario['idUsuario'];
                header('Location: panel.php');
                exit();
            } else {
                $error = "Credenciales incorrectas. Inténtalo nuevamente.";
            }
        } else {
            $error = "Credenciales incorrectas. Inténtalo nuevamente.";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>WebGenerator Agustin Schanwarzkoff</title>
    <style type="text/css">
    body {
    height: 100vh;
    place-items: center;
    display: grid;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.contenedor {
    background: #fff;
    max-width: 380px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.contenedor h2 {
    margin: 0 0 20px;
    color: #333;
    font-size: 24px;
}

.form-group {
    margin-bottom: 20px;
    text-align: left;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

.form-group input {
    width: 94%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

.form-group input::placeholder {
    color: #999;
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
}

input[type="submit"]:hover {
    background-color: #005499;
}

.preg {
    margin-top: 15px;
    color: #333;
}

a {
    color: #0078d4;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.error-message {
    color: red;
    margin-top: 10px;
    font-size: 

</style>
</head>
<body>
    <div class="contenedor">
        <h2>Inicio de sesión</h2>
        <?php if (isset($error)) { ?>
            <p><?php echo $error; ?></p>
        <?php } ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Gmail:</label>
                <input type="text" id="username" name="username" placeholder="Ingresa tu Gmail">
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña">
            </div>
            <input type="submit" name="login" value="Iniciar sesión">

            <h4 class="preg">¿Aún no tienes una cuenta? <a href="register.php">Crear cuenta</a></h4>
        </form>
    </div>
</body>
</html>
