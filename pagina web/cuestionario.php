<?php
session_start();
$carrito_total = 0;
if (isset($_SESSION['usuario_id'])) {
    include("db.php");
    $id_usuario = $_SESSION['usuario_id'];
    $query = "SELECT SUM(cantidad) AS total FROM carrito WHERE id_usuario = '$id_usuario'";
    $resultado = mysqli_query($conexion, $query);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        $carrito_total = $fila['total'] ?? 0;
    }
}

include("db.php"); // conexión a base de datos

// Guardar comentario si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $calidad = mysqli_real_escape_string($conexion, $_POST['calidad']);
    $recomendar = mysqli_real_escape_string($conexion, $_POST['recomendar']);
    $comentario = mysqli_real_escape_string($conexion, trim($_POST['comentarios']));

    $query = "INSERT INTO comentarios (calidad, recomendar, comentario) 
              VALUES ('$calidad', '$recomendar', '$comentario')";
    mysqli_query($conexion, $query);
}

// Obtener todos los comentarios
$queryComentarios = "SELECT * FROM comentarios ORDER BY fecha DESC";
$resultadoComentarios = mysqli_query($conexion, $queryComentarios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Ángel | Cuestionario</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .cuestionario-container {
            max-width: 700px;
            margin: 50px auto;
            background-color: var(--color-fondo);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .cuestionario-container h2 {
            text-align: center;
            font-size: 32px;
            color: var(--color-cafe-oscuro);
            font-style: italic;
        }

        .cuestionario-container label {
            font-weight: bold;
            color: var(--color-texto);
        }

        .cuestionario-container select,
        .cuestionario-container textarea,
        .cuestionario-container input[type="radio"] {
            margin-top: 5px;
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif;
        }

        .cuestionario-container textarea {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: vertical;
        }

        .btn-enviar {
            background-color: var(--color-cafe-oscuro);
            color: var(--color-blanco);
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-enviar:hover {
            background-color: #563c29;
        }

        .publicaciones {
            max-width: 700px;
            margin: 40px auto;
        }

        .publicacion {
            background-color: #fff;
            border: 1px solid var(--color-beige);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .publicacion h4 {
            margin-top: 0;
            color: var(--color-cafe-oscuro);
        }

        .publicacion small {
            color: #888;
        }

        .publicacion p {
            margin: 10px 0 0;
        }

        @media (max-width: 600px) {
            .cuestionario-container, .publicaciones {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<!-- ====== MENÚ ====== -->
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

<!-- ====== SECCIÓN CUESTIONARIO ====== -->
<main>
    <div class="cuestionario-container">
        <h2>Cuestionario</h2>
        <p style="text-align:center;">Por favor, ayúdanos a mejorar respondiendo las siguientes preguntas:</p>

        <form method="post">
            <label>1. ¿Cómo calificarías la calidad de nuestros productos?</label><br>
            <select name="calidad" required>
                <option value="">Selecciona una opción</option>
                <option value="Excelente">Excelente</option>
                <option value="Buena">Buena</option>
                <option value="Regular">Regular</option>
                <option value="Mala">Mala</option>
            </select><br>

            <label>2. ¿Recomendarías nuestra tienda a otras personas?</label><br>
            <input type="radio" name="recomendar" value="Sí" required> Sí
            <input type="radio" name="recomendar" value="No" required style="margin-left:15px;"> No<br>

            <label>3. Comentarios o sugerencias:</label><br>
            <textarea name="comentarios" rows="4" placeholder="Escribe aquí..."></textarea><br>

            <button class="btn-enviar" type="submit">Enviar Respuestas</button>
        </form>
    </div>

    <!-- ====== PUBLICACIONES DE COMENTARIOS ====== -->
    <div class="publicaciones">
        <h2 style="text-align:center;">Opiniones de nuestros clientes</h2>

        <?php while ($fila = mysqli_fetch_assoc($resultadoComentarios)): ?>
            <div class="publicacion">
                <h4><?php echo htmlspecialchars($fila['calidad']); ?> ⭐</h4>
                <small><?php echo date("d/m/Y H:i", strtotime($fila['fecha'])); ?> - ¿Recomienda?: <?php echo $fila['recomendar']; ?></small>
                <p><?php echo nl2br(htmlspecialchars($fila['comentario'])); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<!-- ====== FOOTER ====== -->
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
            <li><a href="https://www.facebook.com/people/Brinquitos/100063763564260/#">Facebook</a></li>
            <li><a href="https://www.instagram.com/brinquitosmonterrey/?igsh=MXU2aThsM3ZrOGNsdA%3D%3D#">Instagram</a></li>
        </ul>
    </div>
</footer>

</body>
</html>
