<?php

require_once('index.html');

/*Se hace la conexión para actualizar la  base de datos*/
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
        updateUrl($fila['link']);//Función para actulizar la bd
        recrusivity_level1($fila['link']);
    }
}

function updateUrl($url){
    $html     =     file_get_contents_curl($url);
    $doc     =     new DOMDocument();
    @$doc->loadHTML($html);
    $nodes     =     $doc->getElementsByTagName('title');
    $title     =     limpiarString($nodes->item(0)->nodeValue);
    $metas     =     $doc->getElementsByTagName('meta');
    for ($i = 0; $i < $metas->length; $i++) :
        $meta = $metas->item($i);
        if ($meta->getAttribute('name') == 'description')
            $description = limpiarString($meta->getAttribute('content'));
        if ($meta->getAttribute('name') == 'keywords')
            $keywords = limpiarString($meta->getAttribute('content'));
        if ($meta->getAttribute('name') == 'date')
            $date = limpiarString($meta->getAttribute('content'));
    endfor;

    //recrusivity_level1($url);

    //Para almacenar en la bd
    $servername = "localhost";
    $database = "rss_news";
    $username = "root";
    $password = "";
    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO noticias (title, date, description, link, keywords) VALUES ( \"" . $title . "\", \"" . $date . "\",
    \"" . $description . "\",\"" . $url . "\",\"" . $keywords . "\")";

    if (mysqli_query($conn, $sql)) {
        echo '<div class="container my-5 bg-dark text-white d-block" id="addLinkContainer">
        <h5>¡Las páginas se actualizaron correctamente!</h5>
        </div>';
    } else {
        echo "<p>No se pudieron actualizar las noticias, intente más tarde :(</p>";
    }
}

if(isset($_GET['indexbtn'])):
    $url 	=	$_GET['url'];

	updateUrl($url);

else:

    echo '<div class="container my-5 bg-dark text-white d-block" id="addLinkContainer">
        <h5>Type a Link to feed the database:</h5>';
    echo '<form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Ej.http://enterprise.com" aria-label="url" name="url" required>
            <button class="btn btn-outline-warning my-2 my-sm-0" type="submit" name="indexbtn">Add to data base</button>
        </form>';
    echo '</div>';
endif;

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

/*Función que sirve para indexar a nivel 1*/
function recrusivity_level1($url){
    $html = file_get_contents_curl($url);
    $doc = new DOMDocument();
    @$doc->loadHTML($html);
    $links = $doc->getElementsByTagName('a');
    for ($i = 0; $i < $links->length; $i++) :
        $oneLink = $links->item($i);
        $info = $oneLink->getAttribute('href');
        echo '<p>' . $info . '</p>';
    endfor;
}

?>