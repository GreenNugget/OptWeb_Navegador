<?php

//Se establece la conexión con la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'rss_news');

if ($conexion) {
    $link;
    $titulo;
    $autor;
    $fecha;
    $descripcion;

    $sql = "select * from `noticias`";
    $resultado = $conexion->query($sql);
    while ($fila = mysqli_fetch_array($resultado)) {
        echo $fila["link"];
        // Operaciones con los resultados que tenemos en $fila

    }

    $conexion->close();
} else {
    echo 'alert("No se pudo conectar a la base de datos");';
}
?>