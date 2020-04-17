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

    if($resultado==null){
        echo '<div class="container my-5 bg-dark text-white d-block">
            <h5>You don´t have news to show :(</h5>
            <p>Use the button ´Add Link´ to add the url of a website</p>
            </div>';
    }elseif($resultado!=null){
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
    }

    $conexion->close();
} else {
    echo 'alert("No se pudo conectar a la base de datos");';
}
?>