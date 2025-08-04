<?php
session_start();
include("db.php");

// Solo admin puede entrar
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container presentacion">
    <h2>Agregar nuevo producto</h2>
    <form action="guardar_producto.php" method="POST" enctype="multipart/form-data" style="max-width:500px; margin:auto;">
        <input type="text" name="nombre" placeholder="Nombre" required><br><br>
        <textarea name="descripcion" placeholder="Descripción" required></textarea><br><br>
        <input type="text" name="categoria" placeholder="Categoría" required><br><br>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required><br><br>
        <input type="file" name="imagen" accept="image/*" required><br><br>
        <button class="btn-3" type="submit">Guardar producto</button>
    </form>
</main>
</body>
</html>

