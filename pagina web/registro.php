<?php
include("db.php");
session_start();
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Cifrado seguro
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, correo, usuario, contrasena, rol)
            VALUES ('$nombre', '$correo', '$usuario', '$hash', 'usuario')";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        $mensaje = "✅ Registro exitoso. Ahora puedes iniciar sesión.";
    } else {
        $mensaje = "❌ Error al registrar: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container presentacion">
    <h2>Registro de Usuario</h2>
    <?php if ($mensaje): ?>
        <p style="color:green;"><?php echo $mensaje; ?></p>
    <?php endif; ?>
    <form method="POST" style="max-width:400px; margin:auto;">
        <input type="text" name="nombre" placeholder="Nombre completo" required><br><br>
        <input type="email" name="correo" placeholder="Correo electrónico" required><br><br>
        <input type="text" name="usuario" placeholder="Nombre de usuario" required><br><br>
        <input type="password" name="contrasena" placeholder="Contraseña" required><br><br>
        <button class="btn-3" type="submit">Registrarse</button>
    </form>
</main>
</body>
</html>
