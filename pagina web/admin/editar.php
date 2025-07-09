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
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1>Editar Producto</h1>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM productos WHERE id_producto = $id";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) == 1) {
        $producto = mysqli_fetch_assoc($resultado);
    } else {
        echo "<p>Producto no encontrado.</p>";
        exit();
    }
} else {
    echo "<p>ID no especificado.</p>";
    exit();
}
?>

<form method="POST" action="">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required><br><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion" required><?php echo $producto['descripcion']; ?></textarea><br><br>

    <label>Categoría:</label><br>
    <input type="text" name="categoria" value="<?php echo $producto['categoria']; ?>" required><br><br>

    <label>Precio:</label><br>
    <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required><br><br>

    <label>Nombre de la Imagen:</label><br>
    <input type="text" name="imagen" value="<?php echo $producto['imagen']; ?>" required><br><br>

    <input type="submit" name="actualizar" value="Actualizar Producto">
</form>

<?php
if (isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen'];

    $query = "UPDATE productos SET 
              nombre='$nombre', 
              descripcion='$descripcion', 
              categoria='$categoria', 
              precio='$precio', 
              imagen='$imagen' 
              WHERE id_producto=$id";

    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<p>Producto actualizado correctamente.</p>";
        echo "<a href='lista.php'>Volver a la lista</a>";
    } else {
        echo "<p>Error al actualizar: " . mysqli_error($conexion) . "</p>";
    }
}
?>

</body>
</html>
