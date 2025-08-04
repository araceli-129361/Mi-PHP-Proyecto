<?php
session_start();
include("db.php");

// Redirigir si no hay sesión de usuario
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// ELIMINAR producto del carrito
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    mysqli_query($conexion, "DELETE FROM carrito WHERE id='$id' AND id_usuario='$usuario_id'");
    header("Location: carrito.php");
    exit();
}

// ACTUALIZAR cantidad
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $carrito_id = $_POST['carrito_id'];
    $nueva_cantidad = max(1, intval($_POST['cantidad']));
    mysqli_query($conexion, "UPDATE carrito SET cantidad='$nueva_cantidad' WHERE id='$carrito_id' AND id_usuario='$usuario_id'");
    header("Location: carrito.php");
    exit();
}

// OBTENER productos del carrito
$query = "SELECT c.id, p.nombre, p.precio, p.imagen, c.cantidad
          FROM carrito c
          JOIN productos p ON c.id_producto = p.id_producto
          WHERE c.id_usuario = '$usuario_id'";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Carrito</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <div class="menu container">
        <h1 class="logo">MI CARRITO</h1>
        <nav class="navbar">
            <ul>
                <li><a href="catalogo.php">Seguir comprando</a></li>
                <li><a href="cerrar.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container presentacion">
    <h2>Productos en tu carrito</h2>
    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><img src="images/<?php echo $row['imagen']; ?>" width="60"></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td>$<?php echo number_format($row['precio'], 2); ?></td>
                    <td>
                        <form method="POST" style="display:flex; justify-content:center;">
                            <input type="hidden" name="carrito_id" value="<?php echo $row['id']; ?>">
                            <input type="number" name="cantidad" value="<?php echo $row['cantidad']; ?>" min="1" style="width:60px;">
                            <button class="btn-3" name="actualizar">Actualizar</button>
                        </form>
                    </td>
                    <td>
                        <a class="btn-4" href="carrito.php?eliminar=<?php echo $row['id']; ?>" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes productos en tu carrito.</p>
    <?php endif; ?>
</main>

</body>
</html>
