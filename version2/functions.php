<?php

//Función para comprobar si un url yaestá en la base de datos
function onDataBase($url){
    $conexion = mysqli_connect('localhost', 'root', '', 'rss_news');

    $sql = "select * from `noticias`";
    $resultado = $conexion->query($sql);
    while ($fila = mysqli_fetch_array($resultado)) {
        if($url == $fila['link']){
            return true;
        }else{
            return false;
        }
    }
}

function updateUrl($url){
    $html = file_get_contents_curl($url);
    $doc = new DOMDocument();
    @$doc->loadHTML($html);
    $nodes = $doc->getElementsByTagName('title');
    $title = limpiarString($nodes->item(0)->nodeValue);
    $metas = $doc->getElementsByTagName('meta');
    for ($i = 0; $i < $metas->length; $i++) :
        $meta = $metas->item($i);
        if ($meta->getAttribute('name') == 'description')
            $description = limpiarString($meta->getAttribute('content'));
        if ($meta->getAttribute('name') == 'keywords')
            $keywords = limpiarString($meta->getAttribute('content'));
        if ($meta->getAttribute('name') == 'date')
            $date = limpiarString($meta->getAttribute('content'));
    endfor;

    $conexion = mysqli_connect('localhost', 'root', '', 'rss_news');
    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    echo"SÍ LLEGA A LA CONSULTA";
    $sql = "UPDATE noticias SET 'title='" . $title . ",'date'=" . $date . ",'keywords'=" . $keywords . ",'description'=" . $description . "WHERE 'link'=" . $url;

    $sql = "INSERT INTO noticias (title, date, description, link, keywords) VALUES ( \"" . $title . "\", \"" . $date . "\",
    \"" . $description . "\",\"" . $url . "\",\"" . $keywords . "\")";
    
    if (mysqli_query($conexion, $sql)) {
        echo '<div class="container my-5 bg-dark text-white d-block" id="addLinkContainer">
        <h5>¡Las páginas se actualizaron correctamente!</h5>
        </div>';
    } else {
        echo '<div class="container my-5 bg-dark text-white d-block" id="addLinkContainer">
        <h6>No se pudieron actualizar las noticias, intente más tarde :(</h6>
        </div>';
    }
}

/* Función para almacenar en la base de datos */
function saveOnDb($url){

    $html = file_get_contents_curl($url);
    $doc = new DOMDocument();
    @$doc->loadHTML($html);
    $nodes = $doc->getElementsByTagName('title');
    $title = limpiarString($nodes->item(0)->nodeValue);
    $metas = $doc->getElementsByTagName('meta');
    for ($i = 0; $i < $metas->length; $i++) :
        $meta = $metas->item($i);
        if ($meta->getAttribute('name') == 'description')
            $description = limpiarString($meta->getAttribute('content'));
        if ($meta->getAttribute('name') == 'keywords')
            $keywords = limpiarString($meta->getAttribute('content'));
        if ($meta->getAttribute('name') == 'date')
            $date = limpiarString($meta->getAttribute('content'));
    endfor;
    
    $conexion = mysqli_connect('localhost', 'root', '', 'rss_news');
    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO noticias (title, date, description, link, keywords) VALUES ( \"" . $title . "\", \"" . $date . "\",
    \"" . $description . "\",\"" . $url . "\",\"" . $keywords . "\")";

    if (mysqli_query($conexion, $sql)) {
        echo '<div class="container my-5 bg-dark text-white d-block" id="addLinkContainer">
        <h5>¡Las páginas se actualizaron correctamente!</h5>
        </div>';
    } else {
        echo "<p>No se pudieron actualizar las noticias, intente más tarde :(</p>";
    }
}

/*Función que sirve para indexar a nivel 1*/
function recrusivity_level1($url){
    $html = file_get_contents_curl($url);
    $doc = new DOMDocument();
    @$doc->loadHTML($html);
    $links = $doc->getElementsByTagName('a');
    for ($i = 0; $i < $links->length; $i++) :
        $oneLink = $links->item($i);
        $info = $oneLink->getAttribute('href');
        $info = $url . $info;
        if(onDataBase($info)){
            updateUrl($info);
        }else{
            saveOnDb($info);
        }
    endfor;
}

// FUNCIONES PARA EL CURL
/* Función para obtener todo el contenido de una página web, scrappeado */
function curl($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $info = curl_exec($ch);
    return $info;
}

/* Función para obtener el contenido de una url */
function file_get_contents_curl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

/* Función para quitarle caracteres innecesarios a los strings */
function limpiarString($String){
    $String = str_replace(array("|", "|", "[", "^", "´", "`", "¨", "~", "]", "'", "#", "{", "}", ".", ""), "", $String);
    return $String;
}

?>