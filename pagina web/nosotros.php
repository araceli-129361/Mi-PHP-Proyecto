<?php
session_start();
include("db.php");
include("contador_carrito.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Ángel | Nosotros</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .presentacion {
            max-width: 1200px;
            margin: 40px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            align-items: center;
            font-family: 'Poppins', serif;
            color: var(--color-texto);
        }

        .presentacion img {
            max-width: 100%;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .presentacion .texto {
            flex: 1;
            min-width: 300px;
        }

        .presentacion h2 {
            font-size: 36px;
            font-style: italic;
            color: var(--color-cafe-oscuro);
            margin-bottom: 20px;
            text-align: center;
        }

        .presentacion p {
            font-size: 18px;
            line-height: 1.6;
            text-align: justify;
        }

        .seccion-nosotros {
            padding: 20px;
            background-color: var(--color-fondo);
        }

        .texto-derecha {
            order: 2;
        }

        @media (max-width: 768px) {
            .presentacion {
                flex-direction: column;
            }

            .texto-derecha {
                order: 1;
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

<!-- ====== SECCIÓN NOSOTROS ====== -->
<section class="seccion-nosotros">
    <div class="presentacion">
        <div class="texto">
            <h2>Un poco de nosotros...</h2>
            <p>Desde 1943, nuestra empresa familiar <strong>Brinquitos</strong> se ha convertido en un pilar de nuestra comunidad, ofreciendo ropa y accesorios para niños de gran calidad a precios justos.</p>
            <p>En nuestra tienda <strong>El Ángel</strong>, ubicada en Monterrey, nos especializamos en ropa para eventos religiosos y sociales: <em>bautizos, primeras comuniones, confirmaciones, bodas y XV años</em>. Nuestro compromiso es acompañar a las familias en sus momentos más especiales.</p>
            <p>La calidad, la elegancia y la atención personalizada son el corazón de nuestro servicio. Te invitamos a formar parte de nuestra historia, donde cada compra es un encuentro familiar que une generaciones.</p>
        </div>
        <img src="images/niños1.png" alt="Niños en evento">
    </div>

    <div class="presentacion">
        <img src="images/niños2.png" alt="Familia con vestidos elegantes">
        <div class="texto texto-derecha">
            <h2>Esencia BRINQUITOS</h2>
            <p>En <strong>Brinquitos</strong>, la calidad no es solo un estándar; es nuestra forma de vida. Cada diseño es un reflejo de nuestra cultura, dedicada al crecimiento y al éxito, manteniéndonos siempre a la vanguardia sin perder nuestra esencia.</p>
            <p>Creemos en la innovación, la creatividad y la distinción, guiados por nuestra misión de brindar no solo productos excepcionales, sino también una atención inigualable a cada cliente.</p>
        </div>
    </div>
</section>

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
