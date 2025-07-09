<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit();
}
?>

<?php include '../db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1>Agregar Producto Nuevo</h1>

<form method="POST" action="">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion" required></textarea><br><br>

    <label>Categoría:</label><br>
    <input type="text" name="categoria" required><br><br>

    <label>Precio:</label><br>
    <input type="number" step="0.01" name="precio" required><br><br>

    <label>Nombre de la Imagen (ej. traje1.jpg):</label><br>
    <input type="text" name="imagen" required><br><br>

    <input type="submit" name="guardar" value="Agregar Producto">
</form>

<?php
if (isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen'];

    $query = "INSERT INTO productos (nombre, descripcion, categoria, precio, imagen) 
              VALUES ('$nombre', '$descripcion', '$categoria', '$precio', '$imagen')";

    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<p>Producto agregado correctamente.</p>";
    } else {
        echo "<p>Error al agregar el producto: " . mysqli_error($conexion) . "</p>";
    }
}
?>

</body>
</html>
