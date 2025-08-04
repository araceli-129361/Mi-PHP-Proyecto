<?php session_start(); ?>

<?php
// Verificamos si se enviaron respuestas
$respuestaEnviada = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $calidad = $_POST['calidad'];
    $recomendar = $_POST['recomendar'];
    $comentarios = trim($_POST['comentarios']);
    $respuestaEnviada = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Ángel | Cuestionario</title>
    <link rel="stylesheet" href="style.css">
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
                </ul>
            </nav>
        </div>
    </header>

    <!-- ====== SECCIÓN CUESTIONARIO ====== -->
    <main class="container presentacion">
        <h2>Cuestionario</h2>
        <p>Por favor, ayúdanos a mejorar respondiendo las siguientes preguntas:</p>

        <form action="" method="post" style="max-width:600px; margin:20px auto; text-align:left;">
            <label>1. ¿Cómo calificarías la calidad de nuestros productos?</label><br>
            <select name="calidad" required>
                <option value="">Selecciona una opción</option>
                <option value="Excelente">Excelente</option>
                <option value="Buena">Buena</option>
                <option value="Regular">Regular</option>
                <option value="Mala">Mala</option>
            </select><br><br>

            <label>2. ¿Recomendarías nuestra tienda a otras personas?</label><br>
            <input type="radio" name="recomendar" value="Sí" required> Sí<br>
            <input type="radio" name="recomendar" value="No" required> No<br><br>

            <label>3. Comentarios o sugerencias:</label><br>
            <textarea name="comentarios" rows="4" style="width:100%;" placeholder="Escribe aquí..."></textarea><br><br>

            <button class="btn-3" type="submit">Enviar Respuestas</button>
        </form>

        <!-- ====== MOSTRAR RESPUESTAS ====== -->
        <?php if ($respuestaEnviada): ?>
            <div style="margin-top:30px; background:#e4d6c3; padding:15px; border-radius:8px;">
                <h3>✅ Respuestas enviadas:</h3>
                <p><strong>Calidad:</strong> <?php echo htmlspecialchars($calidad); ?></p>
                <p><strong>¿Recomendaría la tienda?:</strong> <?php echo htmlspecialchars($recomendar); ?></p>
                <p><strong>Comentarios:</strong> <?php echo nl2br(htmlspecialchars($comentarios)); ?></p>
            </div>
        <?php endif; ?>
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
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>
        </div>
    </footer>

</body>
</html>
