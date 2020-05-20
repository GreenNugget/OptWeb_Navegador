<?php

include 'functions_index.php';
require_once('index.html');

/*Se hace la conexión para actualizar la  base de datos*/
$dbInfo = json_decode(file_get_contents("../db_info.json"));
$conexion = mysqli_connect($dbInfo->host, $dbInfo->user, $dbInfo->password, $dbInfo->database);

if ($conexion) {
    $sql = "select * from `noticias`";
    $resultado = $conexion->query($sql);
    while ($fila = mysqli_fetch_array($resultado)) {//Se va recorriendo la bd para obtener las url
        $isOnDB = onDataBase($fila['link']);
        if($isOnDB == true){
            updateUrl($fila['link']);
            recrusivity_level1($fila['link']);
        }else{
            saveOnDb($fila['link']);
        }
    }
}

?>