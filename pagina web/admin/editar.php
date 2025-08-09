<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}
include '../db.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .mensaje-exito {
            text-align: center;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 10px;
            margin: 20px auto;
            max-width: 500px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<h1 style="text-align:center;">Editar Producto</h1>

<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM productos WHERE id_productos = $id";
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

// Si se envió el formulario para actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen'];

    // Validar precio numérico
    if (!is_numeric($precio)) {
        echo "<script>alert('El precio ingresado no es válido.'); window.history.back();</script>";
        exit();
    }

    // Validar que la imagen exista
    $imagen_path = "../images/" . $imagen;
    if (!file_exists($imagen_path)) {
        echo "<script>
            alert('La imagen no se encuentra en la carpeta /images. Verifica el nombre del archivo.');
            window.history.back();
        </script>";
        exit();
    }

    // Actualizar producto
    $query = "UPDATE productos SET 
              nombre='$nombre', 
              descripcion='$descripcion', 
              categoria='$categoria', 
              precio='$precio', 
              imagen='$imagen' 
              WHERE id_productos=$id";

    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        header("Location: editar.php?id=$id&actualizado=1");
        exit();
    } else {
        echo "<p>Error al actualizar: " . mysqli_error($conexion) . "</p>";
    }
}
?>

<?php if (isset($_GET['actualizado'])): ?>
    <div class="mensaje-exito">✅ Producto actualizado correctamente</div>
<?php endif; ?>

<form method="POST" style="max-width: 500px; margin: auto;">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required><br><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion" required><?php echo $producto['descripcion']; ?></textarea><br><br>

    <label>Categoría:</label><br>
    <input type="text" name="categoria" value="<?php echo $producto['categoria']; ?>" required><br><br>

    <label>Precio:</label><br>
    <input type="number" step="0.01" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required inputmode="decimal"><br><br>

    <label>Nombre de la Imagen:</label><br>
    <input type="text" name="imagen" value="<?php echo $producto['imagen']; ?>" required><br><br>

    <input class="btn-3" type="submit" name="actualizar" value="Actualizar Producto">
</form>
<div style="text-align:center; margin-top: 30px;">
    <a class="btn-3" href="lista.php">← Volver a la lista de productos</a>
</div>


<!-- Bloquear letras no válidas en precio -->
<script>
document.getElementById('precio').addEventListener('keydown', function(e) {
    if (["e", "E", "+", "-", ",", " "].includes(e.key)) {
        e.preventDefault();
    }
});
</script>

</body>
</html>
