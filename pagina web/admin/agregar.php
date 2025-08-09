<?php
include("../db.php");
session_start();

// Solo permitir acceso si es admin
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Insertar producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen']; // Nombre de la imagen (ya subida a /images) 

    // Validar que el precio sea numérico
    if (!is_numeric($precio)) {
        echo "<script>
            alert('El precio ingresado no es válido.');
            window.history.back();
        </script>";
        exit();
    }

    // Verificar si ya existe un producto con ese nombre
    $verificar = mysqli_query($conexion, "SELECT * FROM productos WHERE nombre = '$nombre'");
    if (mysqli_num_rows($verificar) > 0) {
        echo "<script>
            alert('Ya existe un producto con ese nombre.');
            window.location.href='agregar.php';
        </script>";
        exit();
    }

    // Verificar si la imagen existe en la carpeta ../images/
    $imagen_path = "../images/" . $imagen;
    if (!file_exists($imagen_path)) {
        echo "<script>
            alert('La imagen no se encuentra en la carpeta /images. Verifica el nombre del archivo.');
            window.history.back();
        </script>";
        exit();
    }

    // Insertar en la base de datos
    $query = "INSERT INTO productos (nombre, descripcion, categoria, precio, imagen) 
              VALUES ('$nombre', '$descripcion', '$categoria', '$precio', '$imagen')";

    if (mysqli_query($conexion, $query)) {
        echo "<script>
            alert('Producto agregado exitosamente');
            window.location.href='lista.php';
        </script>";
    } else {
        echo "Error al guardar: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto | Admin</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<header class="header">
    <div class="menu container">
        <h1 class="logo">ADMIN - El Ángel</h1>
        <nav class="navbar">
            <ul>
                <li><a href="lista.php">Lista de Productos</a></li>
                <li><a href="agregar.php">Agregar Producto</a></li>
                <li><a href="../cerrar.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container presentacion">
    <h2>Agregar nuevo producto</h2>
    <form method="POST" style="max-width:500px; margin:auto;">
        <input type="text" name="nombre" placeholder="Nombre del producto" required><br>
        <textarea name="descripcion" placeholder="Descripción" required></textarea><br>
        <input type="text" name="categoria" placeholder="Categoría (ej. Bautizo)" required><br>
        <input type="number" step="0.01" name="precio" id="precio" placeholder="Precio" required inputmode="decimal"><br>

        <!-- Aquí solo escribes el nombre de la imagen ya existente -->
        <input type="text" name="imagen" placeholder="Nombre del archivo (ej: vestido1.jpg)" required><br>

        <input class="btn-3" type="submit" value="Agregar">
    </form>
</main>

<!-- Script para bloquear letras en campo precio -->
<script>
document.getElementById('precio').addEventListener('keydown', function(e) {
    if (["e", "E", "+", "-", ",", " "].includes(e.key)) {
        e.preventDefault();
    }
});
</script>

</body>
</html>
