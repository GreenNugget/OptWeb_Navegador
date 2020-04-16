<?php

require_once('index.html');
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

    echo '<div class="container my-5 bg-dark text-white d-block" id="newsContainer">';
    echo '<h2>Your News:</h2>';
    while ($fila = mysqli_fetch_array($resultado)) {
        echo '<div class="container pt-3 my-3 border">';
        echo "<p>Title: " . $fila["titulo"] . '</p>';
        echo '<p><a href="' . $fila['link'] . '" class="card-link">Haz click aquí para ver la noticia</a></p>';
        echo "<p>Description: " . $fila["descripcion"] . "</p>";
        echo '</div>';
    }
    echo '</div>';

    $conexion->close();
} else {
    echo 'alert("No se pudo conectar a la base de datos");';
}
?>