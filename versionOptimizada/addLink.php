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
    $description = 'This page does not have a description';
    $keywords = 'This page does not have a keywords attribute';
    $date = 'This page does not have a date attribute';
    for ($i = 0; $i < $metas->length; $i++):
		$meta = $metas->item($i);
        if($meta->getAttribute('name') == 'description')
        	$description = limpiarString($meta->getAttribute('content'));
        if($meta->getAttribute('name') == 'keywords')
            $keywords = limpiarString($meta->getAttribute('content'));
        if($meta->getAttribute('name') == 'date')
            $date = limpiarString($meta->getAttribute('content'));
    endfor;
    
    $dbInfo = json_decode(file_get_contents("../db_info.json"));
    $connection = mysqli_connect($dbInfo->host, $dbInfo->user, $dbInfo->password, $dbInfo->database);
    if (!$connection) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO noticias (title, date, description, link, keywords) VALUES ( \"".$title."\", \"".$date."\",
    \"".$description."\",\"".$url."\",\"".$keywords."\")";

    if (mysqli_query($connection, $sql)) {
        echo '<div class="container my-5 bg-dark text-white d-block" id="addLinkContainer">
        <h5>¡La página se almacenó correctamente!</h5>
        </div>';
    } else {
        echo '<div class="container my-5 bg-dark text-white d-block" id="addLinkContainer">
        <h5>¡La página ya se encuentra almacenada en la base de datos!</h5>
        </div>';
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