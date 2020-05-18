<?php

require_once('index.html');

if(isset($_GET['addbtn'])):
    $url 	=	$_GET['url'];

	$html 	= 	file_get_contents_curl($url);                    
    $doc 	= 	new DOMDocument();
    @$doc->loadHTML($html);
    $nodes 	= 	$doc->getElementsByTagName('title');
    $title 	= 	limpiarString($nodes->item(0)->nodeValue);
    $metas 	= 	$doc->getElementsByTagName('meta');
    for ($i = 0; $i < $metas->length; $i++):
		$meta = $metas->item($i);
        if($meta->getAttribute('name') == 'description')
        	$description = limpiarString($meta->getAttribute('content'));
        if($meta->getAttribute('name') == 'keywords')
            $keywords = limpiarString($meta->getAttribute('content'));
        if($meta->getAttribute('name') == 'date')
            $date = limpiarString($meta->getAttribute('content'));
    endfor;

    //COMENZAMOS A ALMACENAR EN LA BASE DE DATOS
    $dbInfo = json_decode(file_get_contents("db_info.json"));
    $conn = mysqli_connect($dbInfo->host, $dbInfo->user, $dbInfo->password, $dbInfo->database);
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO noticias (title, date, description, link, keywords) VALUES ( \"".$title."\", \"".$date."\",
    \"".$description."\",\"".$url."\",\"".$keywords."\")";

    if (mysqli_query($conn, $sql)) {
        echo '<div class="container my-5 bg-dark text-white d-block" id="addLinkContainer">
        <h5>¡La página se almacenó correctamente!</h5>
        </div>';
    } else {
            echo "<p>No se pudo realizar la conexión a la base de datos :( </p>";
    }

else:

    echo '<div class="container my-5 bg-dark text-white d-block" id="addLinkContainer">
        <h5>Type a Link to feed the database:</h5>';
    echo '<form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Ej.http://enterprise.com" aria-label="url" name="url" required>
            <button class="btn btn-outline-warning my-2 my-sm-0" type="submit" name="addbtn">Add to data base</button>
        </form>';
    echo '</div>';
endif;

function curl($url){
    $ch = curl_init($url); // Inicia sesión cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
    $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
    curl_close($ch); // Cierra sesión cURL
    return $info; // Devuelve la información de la función
}

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

function limpiarString($String){
    $String = str_replace(array("|", "|", "[", "^", "´", "`", "¨", "~", "]", "'", "#", "{", "}", ".", ""), "", $String);
    return $String;
}

?>