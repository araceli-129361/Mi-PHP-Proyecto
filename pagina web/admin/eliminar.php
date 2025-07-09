<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit();
}
?>

<?php
include '../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM productos WHERE id_producto = $id";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<p>Producto eliminado correctamente.</p>";
    } else {
        echo "<p>Error al eliminar el producto: " . mysqli_error($conexion) . "</p>";
    }
} else {
    echo "<p>ID no especificado.</p>";
    exit();
}
?>

<a href="lista.php">Volver a la lista de productos</a>
