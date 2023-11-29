<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: panel.php');
    exit();
}

require_once 'conexion.php';

$email = $password = $confirmPassword = '';
$error = '';
$message = '';  

if (isset($_POST['registro'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Por favor, ingresa un email válido.";
        } elseif ($password !== $confirmPassword) {
            $error = "Las contraseñas no coinciden. Por favor, inténtalo nuevamente.";
        } else {
            $query = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "El email ya está registrado. Por favor, utiliza otro email.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                $query = "INSERT INTO usuarios (email, password) VALUES (?, ?)";
                $stmt = $conexion->prepare($query);
                $stmt->bind_param("ss", $email, $hashed_password);

                if ($stmt->execute()) {
                    $message = "Registro exitoso. Inicia sesión con tu nueva cuenta.";
                    header('Location: login.php');
                    exit();
                } else {
                    $error = "Error en el registro. Por favor, inténtalo nuevamente.";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>WebGenerator</title>
    <style type="text/css">
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.ubicontenido {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.contenido {
    background: #fff;
    max-width: 360px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.contenido h1 {
    margin: 0 0 20px;
    color: #333;
    font-size: 24px;
}

.contenido label {
    display: block;
    margin-bottom: 5px;
    color: #333;
    text-align: left;
}

.contenido input {
    width: 90%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin-bottom: 15px;
}

.contenido input::placeholder {
    color: #999;
}

.contenido .error-message {
    color: red;
    margin-top: 10px;
    font-size: 14px;
}

.contenido .success-message {
    color: green;
    margin-top: 10px;
    font-size: 14px;
}

.contenido input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #0078d4;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    font-size: 16px;
}

.contenido input[type="submit"]:hover {
    background-color: #005499;
}

    </style>
</head>
<body>
    <section class="ubicontenido">
        <div class="contenido">
            <h1>Registrarte es simple</h1>
            <?php if (!empty($error)) { ?>
                <div class="error-message">
                    <p><?php echo $error; ?></p>
                </div>
            <?php } ?>
            <?php if (!empty($message)) { ?>
                <div class="success-message">
                    <p><?php echo $message; ?></p>
                </div>
            <?php } ?>
            <form action="register.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" value="<?php echo $password; ?>">
                
                <label for="confirm_password">Repetir Contraseña:</label>
                <input type="password" id="confirm_password" name="confirm_password" value="<?php echo $confirmPassword; ?>">
                
                <input type="submit" name="registro" value="Registrarse">
            </form>
        </div>
    </section>
</body>
</html>