<?php
session_start();
include("db.php");

// Verificación de sesión y rol
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$telefono = "525664410630"; // Código internacional +52 (México)

// Obtener productos del carrito
$query = "SELECT p.nombre, c.cantidad, p.precio
          FROM carrito c
          JOIN productos p ON c.id_producto = p.id_producto
          WHERE c.id_usuario = '$id_usuario'";
$result = mysqli_query($conexion, $query);

// Si el carrito está vacío
if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Tu carrito está vacío.'); window.location.href='catalogo.php';</script>";
    exit();
}

// Armar mensaje para WhatsApp
$mensaje = "Hola, quiero hacer un pedido:%0A";
$total = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $nombre = $row['nombre'];
    $cantidad = $row['cantidad'];
    $precio = $row['precio'];
    $subtotal = $cantidad * $precio;
    $total += $subtotal;

    $mensaje .= "- {$cantidad}x {$nombre} ($" . number_format($precio, 2) . ")%0A";
}

$mensaje .= "Total: $" . number_format($total, 2);

// Redirigir a WhatsApp
$url = "https://wa.me/$telefono?text=" . $mensaje;
header("Location: $url");
exit();
