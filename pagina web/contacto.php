<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Ángel | Contacto</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* SECCIÓN CONTACTO HERO CON IMAGEN DE FONDO */
        .contacto-hero {
            background-image: url("images/niños1.png");
            background-size: cover;
            background-position: center;
            height: 400px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .contacto-overlay {
            background-color: rgba(255, 255, 255, 0.92);
            padding: 40px 50px;
            border-radius: 20px;
            max-width: 650px;
            text-align: center;
            font-family: 'Poppins', serif;
            color: var(--color-cafe-oscuro);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .contacto-overlay h2 {
            font-size: 36px;
            font-style: italic;
            margin-bottom: 20px;
            color: var(--color-cafe-oscuro);
        }

        .contacto-overlay p {
            font-size: 18px;
            margin-bottom: 12px;
            color: var(--color-texto);
        }

        @media (max-width: 768px) {
            .contacto-hero {
                height: auto;
                padding: 60px 20px;
            }

            .contacto-overlay {
                padding: 30px 20px;
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

<!-- ====== SECCIÓN CONTACTO CON ESTILO HERO ====== -->
<main class="contacto-hero">
    <div class="contacto-overlay">
        <h2>Contáctanos</h2>
        <p><strong>📞 Teléfono:</strong> 81-1234-5678</p>
        <p><strong>📧 Correo:</strong> contacto@elangel.com</p>
        <p><strong>📍 Dirección:</strong> Calle Ejemplo #123, San Nicolás de los Garza, N.L., México</p>
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
            <li><a href="https://www.facebook.com/brinquitosmonterrey?mibextid=LQQJ4d">Facebook</a></li>
            <li><a href="https://www.instagram.com/brinquitosmonterrey/?igsh=MXU2aThsM3ZrOGNsdA%3D%3D#">Instagram</a></li>
        </ul>
    </div>
</footer>

</body>
</html>
