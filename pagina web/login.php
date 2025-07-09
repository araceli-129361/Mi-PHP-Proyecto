<?php
session_start();
include 'db.php';

if (isset($_POST['ingresar'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$contrasena'";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) == 1) {
        $_SESSION['usuario'] = $usuario;
        header('Location: admin/lista.php');
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Iniciar Sesión</h1>

<form method="POST" action="">
    <label>Usuario:</label><br>
    <input type="text" name="usuario" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="contrasena" required><br><br>

    <input type="submit" name="ingresar" value="Entrar">
</form>

<?php if (isset($error)) { echo "<p>$error</p>"; } ?>

</body>
</html>
