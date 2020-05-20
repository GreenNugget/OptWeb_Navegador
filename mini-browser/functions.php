<?php

//Función para comprobar si un url yaestá en la base de datos
function onDataBase($url){
    $dbInfo = json_decode(file_get_contents("../db_info.json"));
    $conexion = mysqli_connect($dbInfo->host, $dbInfo->user, $dbInfo->password, $dbInfo->database);

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

    //Para almacenar en la bd
    $dbInfo = json_decode(file_get_contents("../db_info.json"));
    $conn = mysqli_connect($dbInfo->host, $dbInfo->user, $dbInfo->password, $dbInfo->database);

    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO noticias (title, date, description, link, keywords) VALUES ( \"" . $title . "\", \"" . $date . "\",
    \"" . $description . "\",\"" . $url . "\",\"" . $keywords . "\") where link=$url";

    if (mysqli_query($conn, $sql)) {
        echo '<div class="container my-5 bg-dark text-white d-block" id="addLinkContainer">
        <h5>¡Las páginas se actualizaron correctamente!</h5>
        </div>';
    } else {
        echo "<p>No se pudieron actualizar las noticias, intente más tarde :(</p>";
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

    $dbInfo = json_decode(file_get_contents("../db_info.json"));
    $conexion = mysqli_connect($dbInfo->host, $dbInfo->user, $dbInfo->password, $dbInfo->database);
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
        //echo '<p>' . $info . '</p>'; //Esto es únicamente para visualizar las urls
    endfor;
}

// FUNCIONES PARA EL CURL
/* Función para obtener todo el contenido de una página web, scrappeado */
function curl($url){
    $ch = curl_init($url); // Inicia sesión cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
    $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
    curl_close($ch); // Cierra sesión cURL
    return $info; // Devuelve la información de la función
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