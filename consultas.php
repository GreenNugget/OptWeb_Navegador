<?php

$conexion = mysqli_connect('localhost','root','','rss_news');

if($conexion){

    $consulta = "select * from `noticias`";
    mysqli_select_db($conexion, "noticias");//se selecciona la bd de donde vamos a obtener datos

    $resultado = mysqli_query($conexion,$consulta, MYSQLI_STORE_RESULT);
    
    while ($fila = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
        echo "<p>
        Link: <a href='$fila[0]'  target='_blank'>$fila[0]</a><br>
        Título: $fila[1]<br>
        Autor: $fila[2]<br>
        Fecha: $fila[3]<br>
        Descripción: $fila[4]<br>
        </p>";
    }
}

?>