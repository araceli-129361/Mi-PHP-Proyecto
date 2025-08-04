<?php
echo "El archivo carga bien.";
?>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("db.php");

// Calcular cantidad de productos en el carrito (si está logueado)
$carrito_total = 0;
if (isset($_SESSION['usuario_id'])) {
    $id_usuario = $_SESSION['usuario_id'];
    $query_carrito = "SELECT SUM(cantidad) AS total FROM carrito WHERE id_usuario = '$id_usuario'";
    $resultado_carrito = mysqli_query($conexion, $query_carrito);
    if ($fila = mysqli_fetch_assoc($resultado_carrito)) {
        $carrito_total = $fila['total'] ?? 0;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Ángel | Catálogo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- ====== MENÚ SUPERIOR ====== -->
<header class="header">
    <div class="menu container">
        <h1 class="logo">EL ÁNGEL</h1>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="catalogo.php">productos</a></li>
                <li><a href="nosotros.php">Nosotros</a></li>
                <li><a href="contacto.php">Contacto</a></li>
                <li><a href="cuestionario.php">Cuestionario</a></li>

                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li><a href="carrito.php">Mi Carrito (<?php echo $carrito_total; ?>)</a></li>
                    <li><a href="cerrar.php">Cerrar sesión</a></li>
                <?php else: ?>
                    <li><a href="login.php">Iniciar sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<!-- Mostrar nombre del usuario si está logueado -->
<?php if (isset($_SESSION['usuario'])): ?>
    <p style="text-align:right; padding:10px; font-weight:bold;">
        Bienvenido, <?php echo htmlspecialchar
