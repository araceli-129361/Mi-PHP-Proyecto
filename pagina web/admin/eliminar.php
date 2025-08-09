<?php
include("../db.php");
session_start();

// Validar que haya sesión activa y que sea admin
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Validar ID y ejecutar eliminación
if ($id) {
    $query = "DELETE FROM productos WHERE id_productos = $id";
    if (mysqli_query($conexion, $query)) {
        echo "<script>
            alert('Producto eliminado correctamente');
            window.location.href='lista.php';
        </script>";
    } else {
        $error = mysqli_error($conexion);
        echo "<script>
            alert('Error al eliminar: $error');
            window.location.href='lista.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID no válido');
        window.location.href='lista.php';
    </script>";
}
?>
