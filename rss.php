<?php
require_once ("simplepie/autoloader.php");

$url = $_POST['url'];
$items = $_POST['numN'];
$feed = new SimplePie();
$feed->set_feed_url($url);
$feed->enable_cache();
$feed->init();

echo '<div class="main-title" align="middle">TUS NOTICIAS';
echo '</div>';
foreach ($feed->get_items($items, $items) as $item) {
    echo '<link rel="stylesheet" href="style.css">';
    echo '<article>';
    echo '<header>';
    echo '<div class="container">';
    echo '<p class="title">Título: <a href="' . $item->get_link() . '">' . $item->get_title() . '</a></p>';
    echo '<p class="newsB">Autor: ' . $item->get_author()->get_name() . '</p>';
    echo '<p class="newsB">Fecha: ' . $item->get_date('Y-m-d') . '</p>';
    echo '<p class="newsB">Descripción: ' . $item->get_description() . '</p>';
    echo '</div>';
    echo '</header>';
    echo $item->get_content(true);
    echo '</article>';
}
echo '<button class="back-button"> <a href="../RSS(Proyecto)/index.html">Haz clic aquí para seleccionar otra noticia :o</a> </button>';
?>