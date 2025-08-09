<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $usuario = trim($_POST['usuario']);
    $contrasena = $_POST['contrasena'];
    $confirmar = $_POST['confirmar'];

    // Validar que coincidan
    if ($contrasena !== $confirmar) {
        echo "<script>alert('Las contraseñas no coinciden');</script>";
    } 
    // Validar requisitos de seguridad
    elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9]).{6,}$/', $contrasena)) {
        echo "<script>alert('La contraseña debe tener al menos 6 caracteres, una mayúscula, una minúscula y un carácter especial.');</script>";
    } else {
        // Validar si ya existe el usuario
        $verificar = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario'");
        if (mysqli_num_rows($verificar) > 0) {
            echo "<script>alert('Este nombre de usuario ya está en uso');</script>";
        } else {
            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $rol = 'usuario';
            $sql = "INSERT INTO usuarios (nombre, correo, usuario, contrasena, rol)
                    VALUES ('$nombre', '$correo', '$usuario', '$hash', '$rol')";
            if (mysqli_query($conexion, $sql)) {
                echo "<script>alert('Registro exitoso'); window.location.href='login.php';</script>";
            } else {
                echo "Error: " . mysqli_error($conexion);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro | El Ángel</title>
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
        .registro-container {
            background-color: #fff9f2;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 350px;
        }
        .registro-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #5d4433;
        }
        .registro-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #c8b7a6;
        }
        .registro-container input[type="submit"] {
            background-color: #5d4433;
            color: white;
            border: none;
            cursor: pointer;
        }
        .registro-container input[type="submit"]:hover {
            background-color: #472f21;
        }
        .toggle-password {
            font-size: 14px;
            color: #5d4433;
            cursor: pointer;
            text-align: right;
            margin-top: -8px;
        }
        .mensaje-contraseña {
            font-size: 13px;
            color: #a04500;
            margin-top: -5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="registro-container">
    <h2>Crear cuenta</h2>
    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="email" name="correo" placeholder="Correo electrónico" required>
        <input type="text" name="usuario" placeholder="Nombre de usuario" required>
        
        <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" required
               pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9]).{6,}"
               title="Debe tener al menos 6 caracteres, una mayúscula, una minúscula y un carácter especial.">
        <div class="toggle-password" onclick="togglePassword('contrasena')">Mostrar contraseña</div>
        <div class="mensaje-contraseña">
            La contraseña debe tener al menos 6 caracteres,
             una mayúscula, una minúscula y un carácter especial.
        </div>

        <input type="password" id="confirmar" name="confirmar" placeholder="Confirmar contraseña" required>
        <div class="toggle-password" onclick="togglePassword('confirmar')">Mostrar confirmación</div>

        <input type="submit" value="Registrarme">
    </form>
</div>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
