<?php
include("db.php");
session_start();
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($contrasena, $row['contrasena'])) {
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario'] = $row['usuario'];
            $_SESSION['rol'] = $row['rol'];

            // Redirigir según el rol
            if ($row['rol'] === 'admin') {
                header("Location: lista.php");
            } else {
                header("Location: catalogo.php");
            }
            exit();
        } else {
            $mensaje = "❌ Contraseña incorrecta.";
        }
    } else {
        $mensaje = "❌ Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container presentacion">
    <h2>Iniciar Sesión</h2>
    <?php if ($mensaje): ?>
        <p style="color:red;"><?php echo $mensaje; ?></p>
    <?php endif; ?>
    <form method="POST" style="max-width:400px; margin:auto;">
        <input type="text" name="usuario" placeholder="Usuario" required><br><br>
        <input type="password" name="contrasena" placeholder="Contraseña" required><br><br>
        <button class="btn-3" type="submit">Entrar</button>
    </form>
    <p style="text-align:center; margin-top:15px;">
        ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
    </p>
</main>
</body>
</html>
