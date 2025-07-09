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
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1>Lista de Productos</h1>
<a href="agregar.php" class="btn-1">Agregar Nuevo Producto</a><br><br>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM productos";
        $resultado = mysqli_query($conexion, $query);

        while($producto = mysqli_fetch_assoc($resultado)) {
        ?>
        <tr>
            <td><?php echo $producto['id_producto']; ?></td>
            <td><?php echo $producto['nombre']; ?></td>
            <td><?php echo $producto['descripcion']; ?></td>
            <td><?php echo $producto['categoria']; ?></td>
            <td>$<?php echo $producto['precio']; ?></td>
            <td><img src="../images/<?php echo $producto['imagen']; ?>" width="50"></td>
            <td>
                <a href="editar.php?id=<?php echo $producto['id_producto']; ?>">Editar</a> |
                <a href="eliminar.php?id=<?php echo $producto['id_producto']; ?>" onclick="return confirm('¿Seguro que quieres eliminar este producto?')">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>
