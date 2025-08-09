<?php
// Mostrar errores para depuración segura
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("db.php");
session_start();

// Procesar el inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $contrasena = $_POST['contrasena'];

    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado && mysqli_num_rows($resultado) == 1) {
        $fila = mysqli_fetch_assoc($resultado);

        if (password_verify($contrasena, $fila['contrasena'])) {
            $_SESSION['usuario'] = $fila['usuario'];
            $_SESSION['usuario_id'] = $fila['id'];
            $_SESSION['rol'] = $fila['rol'];

            if ($fila['rol'] === 'admin') {
                header("Location: admin/lista.php");
            } else {
                header("Location: catalogo.php");
            }
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta');</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión | El Ángel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdfaf7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #fff9f2;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 320px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #5d4433;
        }
        .login-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #c8b7a6;
        }
        .login-container input[type="submit"] {
            background-color: #5d4433;
            color: white;
            border: none;
            cursor: pointer;
        }
        .login-container input[type="submit"]:hover {
            background-color: #472f21;
        }
        .register-link {
            text-align: center;
            margin-top: 15px;
        }
        .register-link a {
            color: #5d4433;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .toggle-password {
            margin-top: -8px;
            font-size: 14px;
            color: #5d4433;
            cursor: pointer;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form method="post" action="">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" required>
            <div class="toggle-password" onclick="mostrarContrasena()">Mostrar contraseña</div>
            <input type="submit" value="Ingresar">
        </form>
        <div class="register-link">
            <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </div>
    </div>

    <script>
        function mostrarContrasena() {
            const input = document.getElementById("contrasena");
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
</html>
