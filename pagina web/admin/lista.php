<?php
include("../db.php");
session_start();

// Solo permitir acceso si es admin
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Obtener productos ordenados por categoría y nombre
$query = "SELECT * FROM productos ORDER BY categoria ASC, nombre ASC";
$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrador | Lista de Productos</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            background-color: #fdf8f3;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            padding: 40px 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #5d4433;
        }
        h3.categoria {
            color: #5d4433;
            margin-top: 40px;
            border-bottom: 2px solid #d9cbb5;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff9f2;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        th, td {
            border: 1px solid #d9cbb5;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f1e3d3;
            color: #5d4433;
        }
        img {
            width: 60px;
            border-radius: 8px;
        }
        .btn-3, .btn-4 {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-3 {
            background-color: #5d4433;
        }
        .btn-3:hover {
            background-color: #3b2d24;
        }
        .btn-4 {
            background-color: #a94442;
        }
        .btn-4:hover {
            background-color: #912d2b;
        }
        nav ul {
            display: flex;
            gap: 20px;
            list-style: none;
            padding: 10px 0;
            justify-content: center;
        }
        nav ul li a {
            text-decoration: none;
            font-weight: bold;
            color: #5d4433;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header class="header">
    <div class="menu container">
        <h1 class="logo" style="text-align:center; padding-top:10px;">ADMIN - EL ÁNGEL</h1>
        <nav class="navbar">
            <ul>
                <li><a href="lista.php">Lista</a></li>
                <li><a href="agregar.php">Agregar</a></li>
                <li><a href="../cerrar.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container">
    <h2>Productos en Inventario</h2>

    <?php
    $categoria_actual = "";

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['categoria'] != $categoria_actual) {
            // Nueva categoría
            if ($categoria_actual != "") {
                echo "</tbody></table>";
            }

            $categoria_actual = $row['categoria'];
            echo "<h3 class='categoria'>" . htmlspecialchars($categoria_actual) . "</h3>";
            echo "<table><thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                  </thead><tbody>";
        }
    ?>
        <tr>
            <td><img src="../images/<?php echo $row['imagen']; ?>" alt="<?php echo $row['nombre']; ?>"></td>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['descripcion']; ?></td>
            <td>$<?php echo number_format($row['precio'], 2); ?></td>
            <td>
                <a class="btn-3" href="editar.php?id=<?php echo $row['id_productos']; ?>">Editar</a>
                <a class="btn-4" href="eliminar.php?id=<?php echo $row['id_productos']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</a>
            </td>
        </tr>
    <?php } ?>
    </tbody></table>
</main>

</body>
</html>
