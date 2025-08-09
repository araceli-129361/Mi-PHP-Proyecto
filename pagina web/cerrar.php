<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sesión finalizada | El Ángel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #fdf8f3;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .mensaje {
            background-color: #fff;
            border: 1px solid #d9cbb5;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .mensaje h2 {
            color: #5d4433;
        }
        .mensaje a {
            display: inline-block;
            margin-top: 20px;
            background-color: #5d4433;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
        }
        .mensaje a:hover {
            background-color: #472f21;
        }
    </style>
</head>
<body>
    <div class="mensaje">
        <h2>Sesión cerrada correctamente</h2>
        <p>Gracias por visitar El Ángel.</p>
        <a href="login.php">Volver a iniciar sesión</a>
    </div>
</body>
</html>
