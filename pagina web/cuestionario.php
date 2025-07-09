<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cuestionario / Opinión</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Cuestionario de Opinión</h1>

<form method="POST" action="">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Correo Electrónico:</label><br>
    <input type="email" name="correo" required><br><br>

    <label>¿Qué te pareció nuestra tienda?</label><br>
    <select name="satisfaccion" required>
        <option value="">Selecciona una opción</option>
        <option value="Excelente">Excelente</option>
        <option value="Buena">Buena</option>
        <option value="Regular">Regular</option>
        <option value="Mala">Mala</option>
    </select><br><br>

    <label>Comentarios adicionales:</label><br>
    <textarea name="comentarios" rows="4"></textarea><br><br>

    <input type="submit" name="enviar" value="Enviar Opinión">
</form>

<?php
if (isset($_POST['enviar'])) {
    $nombre = htmlspecialchars($_POST['nombre']);
    $correo = htmlspecialchars($_POST['correo']);
    $satisfaccion = htmlspecialchars($_POST['satisfaccion']);
    $comentarios = htmlspecialchars($_POST['comentarios']);

    echo "<h2>¡Gracias por tu opinión, $nombre!</h2>";
    echo "<p><strong>Correo:</strong> $correo</p>";
    echo "<p><strong>Tu opinión:</strong> $satisfaccion</p>";
    echo "<p><strong>Comentarios:</strong> $comentarios</p>";
}
?>

</body>
</html>
