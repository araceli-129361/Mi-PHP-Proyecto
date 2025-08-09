<?php
// Configuración para mostrar todos los errores (solo para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión y verificar autenticación
session_start();
include("db.php");

/**
 * Verifica si el usuario está autenticado y tiene rol de usuario normal
 * Redirige a login si no cumple los requisitos
 */
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

/**
 * Procesa el formulario de finalización de pedido:
 * 1. Transfiere los productos del carrito a la tabla de compras
 * 2. Vacía el carrito del usuario
 * 3. Establece flag en localStorage para mostrar mensaje de éxito
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finalizar_pedido'])) {
    // Obtener productos del carrito
    $consulta_carrito = mysqli_query($conexion, "SELECT * FROM carrito WHERE id_usuario='$usuario_id'");
    
    // Transferir cada producto a compras
    while ($producto = mysqli_fetch_assoc($consulta_carrito)) {
        $id_producto = $producto['id_productos'];
        $talla = $producto['talla'];
        $cantidad = $producto['cantidad'];

        mysqli_query($conexion, "INSERT INTO compras (id_usuario, id_producto, talla, cantidad)
                               VALUES ('$usuario_id', '$id_producto', '$talla', '$cantidad')");
    }

    // Vaciar carrito
    mysqli_query($conexion, "DELETE FROM carrito WHERE id_usuario='$usuario_id'");
    
    // Establecer flag y redirigir
    echo "<script>localStorage.setItem('compra_exitosa', '1');</script>";
    echo "<script>window.location.href = 'carrito.php';</script>";
    exit();
}

/**
 * Procesa la adición de productos al carrito:
 * - Si el producto ya está en el carrito, aumenta la cantidad
 * - Si no existe, lo inserta como nuevo registro
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    // Sanitizar inputs
    $id_producto = intval($_POST['id_producto']);
    $talla = mysqli_real_escape_string($conexion, $_POST['talla']);
    $cantidad = intval($_POST['cantidad']);

    // Verificar si el producto ya está en el carrito
    $verifica = mysqli_query($conexion, 
        "SELECT * FROM carrito 
         WHERE id_usuario='$usuario_id' 
         AND id_productos='$id_producto' 
         AND talla='$talla'");

    if (mysqli_num_rows($verifica) > 0) {
        // Actualizar cantidad si ya existe
        $row = mysqli_fetch_assoc($verifica);
        $nuevaCantidad = $row['cantidad'] + $cantidad;
        mysqli_query($conexion, 
            "UPDATE carrito SET cantidad='$nuevaCantidad' 
             WHERE id='{$row['id']}'");
    } else {
        // Insertar nuevo registro si no existe
        $result = mysqli_query($conexion, 
            "INSERT INTO carrito (id_usuario, id_productos, talla, cantidad) 
             VALUES ('$usuario_id', '$id_producto', '$talla', '$cantidad')");
        
        if (!$result) {
            die("Error al insertar en carrito: " . mysqli_error($conexion));
        }
    }

    header("Location: carrito.php");
    exit();
}

/**
 * Elimina un producto del carrito basado en el ID recibido por GET
 */
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    mysqli_query($conexion, 
        "DELETE FROM carrito 
         WHERE id='$id' 
         AND id_usuario='$usuario_id'");
    header("Location: carrito.php");
    exit();
}

/**
 * Actualiza la cantidad de un producto en el carrito
 * Asegura que la cantidad sea al menos 1
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $carrito_id = intval($_POST['carrito_id']);
    $nueva_cantidad = max(1, intval($_POST['cantidad']));
    
    mysqli_query($conexion, 
        "UPDATE carrito SET cantidad='$nueva_cantidad' 
         WHERE id='$carrito_id' 
         AND id_usuario='$usuario_id'");
    
    header("Location: carrito.php");
    exit();
}

// Obtener productos del carrito para mostrar
$query = "SELECT c.id, p.nombre, p.precio, p.imagen, c.cantidad, c.talla
          FROM carrito c
          LEFT JOIN productos p ON c.id_productos = p.id_productos
          WHERE c.id_usuario = '$usuario_id'";
$resultado = mysqli_query($conexion, $query);

// Obtener historial de compras del usuario
$query_compras = "SELECT cp.*, pr.nombre, pr.imagen, pr.precio 
                 FROM compras cp
                 LEFT JOIN productos pr ON cp.id_producto = pr.id_productos
                 WHERE cp.id_usuario = '$usuario_id'
                 ORDER BY cp.fecha DESC";
$compras_resultado = mysqli_query($conexion, $query_compras);

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Carrito</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos para los items del carrito */
        .carrito-item {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
            align-items: center;
        }
        
        .carrito-item img {
            width: 80px;
            height: auto;
            border-radius: 8px;
        }
        
        .carrito-detalles {
            flex: 1;
        }
        
        .acciones {
            display: flex;
            gap: 10px;
        }
        
        /* Estilos para el historial de compras */
        .compra-item {
            display: flex;
            gap: 20px;
            margin: 20px 0;
            padding: 15px;
            background-color: #fff9f2;
            border: 1px solid #e4d6c3;
            border-radius: 10px;
        }
        
        .compra-item img {
            width: 80px;
            height: auto;
            border-radius: 8px;
        }
        
        .compra-detalles {
            flex: 1;
        }
        
        .compra-detalles p {
            margin: 5px 0;
        }
    </style>
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
    <h2 style="text-align:center; margin-bottom: 20px;">Productos en tu carrito</h2>

    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
            <?php
            // Verificar si el producto fue eliminado del catálogo
            if ($row['nombre'] === null) {
                echo "<p style='color:red;'>Producto eliminado del catálogo.</p>";
                continue;
            }
            
            // Calcular subtotal y total
            $subtotal = $row['precio'] * $row['cantidad'];
            $total += $subtotal;
            ?>
            
            <div class="carrito-item">
                <img src="images/<?php echo htmlspecialchars($row['imagen']); ?>" 
                     alt="<?php echo htmlspecialchars($row['nombre']); ?>">
                <div class="carrito-detalles">
                    <h3><?php echo htmlspecialchars($row['nombre']); ?></h3>
                    <p>Talla: <?php echo htmlspecialchars($row['talla']); ?></p>
                    <p>Precio: $<?php echo number_format($row['precio'], 2); ?> MXN</p>
                    <p>Subtotal: $<?php echo number_format($subtotal, 2); ?> MXN</p>
                    
                    <form method="POST" class="acciones">
                        <input type="hidden" name="carrito_id" value="<?php echo $row['id']; ?>">
                        <input type="number" name="cantidad" value="<?php echo $row['cantidad']; ?>" min="1" style="width:60px;">
                        <button class="btn-3" name="actualizar">Actualizar</button>
                        <a class="btn-4" href="carrito.php?eliminar=<?php echo $row['id']; ?>" 
                           onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>

        <div style="text-align:right; margin-top:20px;">
            <h3>Total: $<?php echo number_format($total, 2); ?> MXN</h3>
            <button class="btn-3" onclick="document.getElementById('modal-pedido').style.display='block'">
                Finalizar pedido
            </button>
        </div>
    <?php else: ?>
        <p>No tienes productos en tu carrito.</p>
    <?php endif; ?>

    <!-- SECCIÓN DE COMPRAS POR PROCESAR -->
    <?php if (mysqli_num_rows($compras_resultado) > 0): ?>
        <hr>
        <h2 style="text-align:center; margin: 40px 0 20px;">Compras por procesar</h2>
        
        <?php while ($row = mysqli_fetch_assoc($compras_resultado)): ?>
            <div class="compra-item">
                <img src="images/<?php echo htmlspecialchars($row['imagen']); ?>" 
                     alt="<?php echo htmlspecialchars($row['nombre']); ?>">
                <div class="compra-detalles">
                    <h3><?php echo htmlspecialchars($row['nombre']); ?></h3>
                    <p>Talla: <?php echo htmlspecialchars($row['talla']); ?></p>
                    <p>Cantidad: <?php echo $row['cantidad']; ?></p>
                    <p>Precio unitario: $<?php echo number_format($row['precio'], 2); ?> MXN</p>
                    <p>Fecha: <?php echo date("d/m/Y H:i", strtotime($row['fecha'])); ?></p>
                    <p style="font-weight:bold; color:#b8860b;">Estado: <?php echo htmlspecialchars($row['estado']); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</main>

<!-- MODAL DE COMPRA - ACTUALIZADO -->
<div id="modal-pedido" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6); z-index:1000; overflow-y:auto;">
    <div style="background:white; max-width:500px; margin:5% auto; padding:30px; border-radius:10px; position:relative; font-family:inherit; box-shadow:0 5px 15px rgba(0,0,0,0.1);">
        <h2 style="text-align:center; margin-bottom:20px; color:#333;">Detalles del pedido</h2>
        
        <form method="POST" style="display:flex; flex-direction:column; gap:15px;">
            <!-- Campo Nombre Completo -->
            <div style="display:flex; flex-direction:column;">
                <label style="margin-bottom:5px; font-weight:bold;">Nombre completo:</label>
                <input type="text" required style="padding:10px; border:1px solid #ddd; border-radius:4px; font-size:16px;">
            </div>
            
            <!-- Campo Teléfono -->
            <div style="display:flex; flex-direction:column;">
                <label style="margin-bottom:5px; font-weight:bold;">Teléfono:</label>
                <input type="tel" maxlength="10" pattern="[0-9]{10}" required 
                       style="padding:10px; border:1px solid #ddd; border-radius:4px; font-size:16px;"
                       title="Ingresa un número de 10 dígitos">
            </div>
            
            <!-- Campo Dirección -->
            <div style="display:flex; flex-direction:column;">
                <label style="margin-bottom:5px; font-weight:bold;">Dirección de entrega:</label>
                <textarea required style="padding:10px; border:1px solid #ddd; border-radius:4px; min-height:80px; font-size:16px;"></textarea>
            </div>
            
            <!-- Método de Pago -->
            <div style="display:flex; flex-direction:column;">
                <label style="margin-bottom:5px; font-weight:bold;">Método de pago:</label>
                <select required style="padding:10px; border:1px solid #ddd; border-radius:4px; font-size:16px;">
                    <option value="">Seleccionar</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="tarjeta">Tarjeta</option>
                </select>
            </div>
            
            <!-- Fecha de Entrega -->
            <div style="display:flex; flex-direction:column;">
                <label style="margin-bottom:5px; font-weight:bold;">Fecha preferida de entrega:</label>
                <input type="date" required min="<?php echo date('Y-m-d'); ?>" 
                       style="padding:10px; border:1px solid #ddd; border-radius:4px; font-size:16px;">
            </div>
            
            <!-- Empacado para Regalo -->
            <div style="display:flex; flex-direction:column;">
                <label style="margin-bottom:5px; font-weight:bold;">¿Deseas empaque para regalo?</label>
                <select required style="padding:10px; border:1px solid #ddd; border-radius:4px; font-size:16px;">
                    <option value="">Seleccionar</option>
                    <option value="no">No</option>
                    <option value="si">Sí</option>
                </select>
            </div>
            
            <!-- Comentarios Adicionales -->
            <div style="display:flex; flex-direction:column;">
                <label style="margin-bottom:5px; font-weight:bold;">Comentarios adicionales:</label>
                <textarea rows="3" style="padding:10px; border:1px solid #ddd; border-radius:4px; font-size:16px;"></textarea>
            </div>
            
            <input type="hidden" name="finalizar_pedido" value="1">
            
            <!-- Botones de acción -->
            <div style="display:flex; gap:10px; justify-content:center; margin-top:20px;">
                <button type="submit" class="btn-3" style="padding:12px 25px; border:none; cursor:pointer; font-size:16px;">
                    Realizar compra
                </button>
                <button type="button" class="btn-4" onclick="document.getElementById('modal-pedido').style.display='none'" 
                        style="padding:12px 25px; border:none; cursor:pointer; font-size:16px;">
                    Cancelar
                </button>
            </div>
        </form>
        
        <!-- Mensaje de éxito (se muestra después de completar la compra) -->
        <div id="mensaje-exito" style="display:none; font-weight:bold; color:green; text-align:center; margin-top:20px; padding:15px; background:#f0fff0; border-radius:4px; border:1px solid #d4edda;">
            ¡Compra realizada exitosamente!
        </div>
    </div>
</div>

<script>
/**
 * Maneja la visualización del mensaje de compra exitosa
 * - Verifica si hay una compra reciente en localStorage
 * - Muestra el mensaje por 3 segundos si existe
 * - Limpia el flag después de mostrarlo
 */
document.addEventListener("DOMContentLoaded", () => {
    if (localStorage.getItem("compra_exitosa") === "1") {
        // Mostrar mensaje de éxito y ocultar formulario
        document.getElementById('modal-pedido').style.display = 'block';
        document.querySelector('#modal-pedido form').style.display = 'none';
        document.getElementById('mensaje-exito').style.display = 'block';

        // Ocultar después de 3 segundos y limpiar
        setTimeout(() => {
            document.getElementById('modal-pedido').style.display = 'none';
            document.querySelector('#modal-pedido form').style.display = 'block';
            document.getElementById('mensaje-exito').style.display = 'none';
            localStorage.removeItem("compra_exitosa");
        }, 3000);
    }
});
</script>

</body>
</html>
