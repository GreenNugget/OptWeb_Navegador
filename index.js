window.onload = function(){
    document.getElementById('verNoticias').onclick = function(){
        //var dates = <?php echo json_encode($arregloFechas); ?>;
    };
}

/* Algoritmo de ordenamiento que recibe como parámetro un array */
function quickSort(array) {
    if (array.length < 1) {
        return [];
    }
    var left = [];
    var right = [];
    var pivot = array[0];
    for (var i = 1; i < array.length; i++) {
        if (array[i] < pivot) {
            left.push(array[i]);
        }
        else {
            right.push(array[i]);
        }
    }

    return [].concat(quickSort(left), pivot, quickSort(right));
}