<?php

$conexion = mysqli_connect('localhost','root','','rss_news');

if($conexion){

    $consulta = "select * from `noticias`";
    mysqli_select_db($conexion, "noticias");//se selecciona la bd de donde vamos a obtener datos

    $resultado = mysqli_query($conexion,$consulta, MYSQLI_STORE_RESULT);

    echo "<div class='row'>";
    while ($fila = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
        echo "<p>
        Link: <a href='$fila[0]'  target='_blank'>$fila[0]</a><br>
        $fila[1];<br>
        $fila[2];<br>
        $fila[3];<br>
        $fila[4];<br>
        </p>";
    }
    echo "</div>";

   /* $arregloFechas = [];
    mysqli_select_db($conexion,'rss_news');
    $result = mysqli_query($conexion,"select 'fecha' from noticias");
    while(($fila = mysqli_fetch_array($result))!=NULL){
        $fila = $result -> fetch_array(MYSQLI_ASSOC);
        array_push($arregloFechas,$fila);
    }
    echo "<script>
        var dates = <?php echo json_encode($arregloFechas);?>;
        for(var i=0;i<dates.length;i++){
            document.write(dates(i));
        }
    </script>";*/
}

?>