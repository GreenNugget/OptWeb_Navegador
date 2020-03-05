<?php

$conexion = mysqli_connect('localhost', 'root', '', 'rss_news');

if($conexion){
    $arregloFechas = [];
    mysqli_select_db($conexion,'rss_news');
    $result = mysqli_query($conexion,"select 'fecha' from noticias");
    while(($fila = mysqli_fetch_array($result))!=NULL){
        //echo $result;
        $fila = $result -> fetch_array(MYSQLI_ASSOC);
        array_push($arregloFechas,$fila);
    }
    echo "<script>
        var dates = <?php echo json_encode($arregloFechas);?>;
        for(var i=0;i<dates.length;i++){
            document.write(dates(i));
        }
    </script>";
}

?>