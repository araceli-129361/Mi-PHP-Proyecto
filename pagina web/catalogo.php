<?php
// Mostrar errores para depuración (debes quitar esto en producción final)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("db.php");

// Inicializar contador del carrito
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
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            max-width: 300px;
        }

        .modal-content select, .modal-content input {
            margin: 10px 0;
            padding: 8px;
            width: 100%;
        }

        .titulo-categoria {
            font-family: 'Georgia', 'Times New Roman', serif;
            text-align: center;
            font-size: 32px;
            color: var(--color-cafe-oscuro);
            margin-top: 60px;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--color-cafe-claro);
            padding-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInTitulo 0.8s ease-out forwards;
        }

        @keyframes fadeInTitulo {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<header class="header">
    <div class="menu container">
        <h1 class="logo">EL ÁNGEL</h1>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="catalogo.php">Productos</a></li>
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

<?php if (isset($_SESSION['usuario'])): ?>
    <p style="text-align:right; padding:10px; font-weight:bold;">
        Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>
    </p>
<?php endif; ?>

<main class="container">
    <h2 style="text-align:center; margin-top:30px;">Catálogo de Productos</h2>

    <?php
    // Obtener productos ordenados por categoría
    $sql = "SELECT * FROM productos ORDER BY categoria, nombre";
    $resultado = mysqli_query($conexion, $sql);

    $categoria_actual = "";
    $primera_seccion = true;

    while ($producto = mysqli_fetch_assoc($resultado)) {
        if ($producto['categoria'] !== $categoria_actual) {
            if (!$primera_seccion) {
                echo '</div>'; // cerrar sección anterior
            }

            $categoria_actual = $producto['categoria'];
            echo '<h2 class="titulo-categoria">' . htmlspecialchars($categoria_actual) . '</h2>';
            echo '<div class="oferts-content">';
            $primera_seccion = false;
        }

        echo '<div class="ofert-1">';
        echo '  <img src="images/' . $producto['imagen'] . '" alt="' . $producto['nombre'] . '">';
        echo '  <div class="product-txt">';
        echo '    <h3>' . $producto['nombre'] . '</h3>';
        echo '    <p>' . $producto['descripcion'] . '</p>';
        echo '    <p class="precio">$' . number_format($producto['precio'], 2) . ' MXN</p>';

        if (isset($_SESSION['usuario_id'])) {
            echo '<button class="btn-3" onclick="abrirModal(' . $producto['id_productos'] . ')">Añadir</button>';
        } else {
            echo '<p><a class="btn-3" href="login.php">Inicia sesión para añadir</a></p>';
        }

        echo '  </div>';
        echo '</div>';
    }

    echo '</div>'; // cerrar la última sección
    ?>
</main>

<!-- Modal -->
<div class="modal" id="modal">
    <div class="modal-content">
        <h3>Selecciona talla y cantidad</h3>
        <form method="POST" action="carrito.php">
            <input type="hidden" name="id_producto" id="id_producto_modal">
            <label for="talla">Talla:</label>
            <select name="talla" required>
                <option value="">Seleccionar</option>
                <option value="Ch">Ch</option>
                <option value="M">M</option>
                <option value="G">G</option>
            </select>
            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" min="1" value="1" required>
            <button class="btn-3" type="submit">Agregar al carrito</button>
        </form>
        <button class="btn-4" onclick="cerrarModal()">Cancelar</button>
    </div>
</div>

<script>
function abrirModal(id) {
    document.getElementById('id_producto_modal').value = id;
    document.getElementById('modal').style.display = 'flex';
}
function cerrarModal() {
    document.getElementById('modal').style.display = 'none';
}
</script>

<footer class="footer">
    <div class="link">
        <h3>El Ángel</h3>
        <ul>
            <li><a href="nosotros.php">Sobre Nosotros</a></li>
            <li><a href="contacto.php">Contáctanos</a></li>
        </ul>
    </div>
    <div class="link">
        <h3>Síguenos</h3>
        <ul>
            <li><a href="https://www.facebook.com/brinquitosmonterrey?mibextid=LQQJ4d">Facebook</a></li>
            <li><a href="https://www.instagram.com/brinquitosmonterrey/?igsh=MXU2aThsM3ZrOGNsdA%3D%3D#">Instagram</a></li>
        </ul>
    </div>
</footer>

</body>
</html>
