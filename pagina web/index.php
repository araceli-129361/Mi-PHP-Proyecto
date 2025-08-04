<?php
// Iniciamos sesión para detectar si el usuario está logueado
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Ángel | Inicio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- ====== MENÚ SUPERIOR (se adapta según sesión) ====== -->
    <header class="header">
        <div class="menu container">
            <h1 class="logo">EL ÁNGEL</h1>

            <!-- Menú de navegación -->
            <nav class="navbar">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="catalogo.php">productos</a></li>
                    <li><a href="nosotros.php">Nosotros</a></li>
                    <li><a href="contacto.php">Contacto</a></li>
                    <li><a href="cuestionario.php">Cuestionario</a></li>

                    <!-- Si hay sesión iniciada, mostrar "Cerrar sesión" -->
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <li><a href="cerrar.php">Cerrar sesión</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Iniciar sesión</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Mostrar mensaje de bienvenida si hay sesión -->
    <?php if (isset($_SESSION['usuario'])): ?>
        <p style="text-align:right; padding:10px; font-weight:bold;">
            Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>
        </p>
    <?php endif; ?>

    <!-- ====== BANNER PRINCIPAL ====== -->
    <section class="banner">
        <div class="banner-content">
            <h2>Bienvenidos a El Ángel</h2>
            <p>Ropa y accesorios para eventos religiosos y sociales: Bautizos, Comuniones, Bodas y XV años.</p>
        </div>
    </section>

    <!-- ====== SECCIÓN DE PRESENTACIÓN ====== -->
    <main class="container presentacion">
        <h2>Tu mejor opción para ocasiones especiales</h2>
        <p>Contamos con una gran variedad de vestidos, trajes y accesorios para todo tipo de evento especial.
           Nuestro objetivo es ofrecerte calidad y elegancia a precios accesibles.</p>
    </main>

    <!-- ====== PIE DE PÁGINA ====== -->
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
