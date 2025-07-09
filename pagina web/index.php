<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EL ÁNGEL</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header class="header">
        <div class="menu container">
            <a href="#" class="logo">logo</a>
            <input type="checkbox" id="menu">
            <label for="menu">
                <img src="" alt="menu">
            </label>
            <nav class="navbar">
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Productos</a></li>
                    <li><a href="#">Servicios</a></li>
                    <li><a href="#">Contacto</a></li>
                    <li><a
             href="cuestionario.php">Cuestionario</a></li>

                </ul>
            </nav>
            <div>
                <ul>
                    <li>
                        <img src="carrito.png" id="img-carrito" alt="">
                        <div id="carrito">
                            <table id="lista-carrito">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <a href="#" id="vaciar-carrito" class="btn-2">Vaciar Carrito</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="header-content container">
            <div class="header-txt">
                <h1>Ofertas Especiales</h1>
                <p>Estrena los mejores productos</p>
                <a href="#" class="btn-1">Información</a>
            </div>
            <div class="header-img">
                <img src="" alt="">
            </div>
        </div>
    </header>

    <section class="oferts container" id="lista-1">
        <h2>Productos</h2>
        <p>A continuación te mostramos algunos de nuestros productos disponibles:</p>
        <div class="oferts-content">
            <?php
            $query = mysqli_query($conexion, "SELECT * FROM productos");

            while($producto = mysqli_fetch_assoc($query)) {
            ?>
                <div class="ofert-1">
                    <img src="images/<?php echo $producto['imagen']; ?>" alt="">
                    <div class="product-txt">
                        <h3><?php echo $producto['nombre']; ?></h3>
                        <p><?php echo $producto['descripcion']; ?></p>
                        <p class="precio">$<?php echo $producto['precio']; ?></p>
                        <a href="#" class="agregar-carrito btn-3">Agregar</a>
                        <a href="https://wa.me/5218112345678?text=Hola,%20quiero%20cotizar%20este%20producto:%20<?php echo urlencode($producto['nombre']); ?>" target="_blank" class="btn-4">Cotizar por WhatsApp</a>

                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <section class="promotion">
        <div class="promotion-content container">
            <div class="promotion-txt">
                <h2>Los mejores productos al mejor precio</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa voluptas illum eaque accusamus.</p>
                <a href="#" class="btn-1">Información</a>
            </div>
            <div class="promotion-img">
                <img src="" alt="">
            </div>
        </div>
    </section>

    <footer class="footer container">
        <div class="link">
            <h3>Enlaces Rápidos</h3>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Productos</a></li>
                <li><a href="#">Contacto</a></li>
                <li><a href="#">Términos</a></li>
            </ul>
        </div>
        <div class="link">
            <h3>Información</h3>
            <ul>
                <li><a href="#">Preguntas Frecuentes</a></li>
                <li><a href="#">Política de Privacidad</a></li>
                <li><a href="#">Envíos</a></li>
                <li><a href="#">Devoluciones</a></li>
            </ul>
        </div>
        <div class="link">
            <h3>Contacto</h3>
            <ul>
                <li><a href="#">WhatsApp</a></li>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">Correo electrónico</a></li>
            </ul>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
