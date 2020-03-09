<!DOCTYPE html>

<head>
    <title>Noticias</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <script src="index.js"></script>
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container">
        <header class="page-header">
            <i> <img src="https://upload.wikimedia.org/wikipedia/commons/4/43/Feed-icon.svg" alt="rss_logo" width="30px" height="30px"> </i>
            <h3>Lector de noticias</h3>
        </header> <br>
        <form action="rss.php" method="POST" class="text-center">
            <div class="row">
                <label for="url"> Ingresa la url que desees: </label>
                <input class="form-control" type="text" id="url" name="url" placeholder="Ingresa tu url aquí :D" />
            </div> <br> <br>
            <div class="row">
                <label for="numN"> Número de noticias que quieres ver: </label>
                <input class="form-control" type="text" id="numN" name="numN" placeholder="10" required />
            </div> <br> <br>
            <input type="submit" id="verNoticias" value="Ver Noticias" class="btn btn-primary">
        </form> <br>
    </div>
    <?php include 'consultas.php'; ?>
    <div class="news_Space" id="news_Space">
        <div class="row2">
            <label for="select_sort">Elija una forma de ordenamiento: </label>
            <select class="select_sort" name="select_sort" id="select_sort">
                <option value="day">Día</option>
                <option value="month">Mes</option>
                <option value="year">Año</option>
            </select>
            <button class="btn btn-warning" id="sort_button">Ordenar</button>
        </div>
    </div>
</body>