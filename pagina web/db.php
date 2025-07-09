<?php
$host = "sql100.infinityfree.com";
$user = "if_39424175";
$pass = "JMB82mz7Xwf";
$db = "if_39424175_tienda"; 

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}
?>