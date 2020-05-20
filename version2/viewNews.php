<?php

require_once('index.html');
//Se establece la conexión con la base de datos
$dbInfo = json_decode(file_get_contents("../db_info.json"));
$conexion = mysqli_connect($dbInfo->host, $dbInfo->user, $dbInfo->password, $dbInfo->database);

if ($conexion) {
    $link;
    $titulo;
    $autor;
    $fecha;
    $descripcion;

    $sql = "select * from noticias ORDER BY date DESC";
    $resultado = $conexion->query($sql);

    echo '<div class="container my-5 bg-dark text-white d-block" id="newsContainer">
        <h2>Your Urls:</h2>';
    while ($fila = mysqli_fetch_array($resultado)) {
        echo '<div class="container pt-3 my-3 border">';
        echo "<p>Title: " . $fila["title"] . '</p>';
        echo "<p>Description: " . $fila["description"] . "</p>";
        echo '<p><a href="' . $fila['link'] . '" class="card-link" target="_blank">Visita la página haciendo click AQUÍ</a></p>';
        echo '</div>';
    }
    echo '</div>';

    $conexion->close();
} else {
    echo 'alert("No se pudo conectar a la base de datos");';
}
?>