<?php
require_once ("simplepie/autoloader.php");

$url = $_POST['url'];
$items = $_POST['numN'];
$feed = new SimplePie();
$feed->set_feed_url($url);
$feed->enable_cache();
$feed->init();

//Se establece la conexión con la base de datos
$conexion = mysqli_connect('localhost','root','','rss_news');

if($conexion){    
    $link;
    $titulo;
    $autor;
    $fecha;
    $descripcion;
    
    foreach ($feed->get_items($items, $items) as $item) {
        $link = $item->get_link();
        $titulo = $item->get_title();
        $autor = $item->get_author()->get_name();
        $fecha = $item->get_date('Y-m-d');
        $descripcion = $item->get_description();
        echo $item->get_content(true);

        $sql = "insert into `noticias` (link, titulo, autor, fecha, descripcion) values ('$link', '$titulo', '$autor', '$fecha','$descripcion')";
        $resultado = $conexion->query($sql);
    }
    $conexion->close();
    echo '<button class="back-button"> <a href="../RSS(Proyecto)/index.html">Haz clic aquí para seleccionar otra noticia :o</a> </button>';
}else{
    echo'alert("No se pudo conectar a la base de datos");';
}
?>