<!DOCTYPE html>

<head>
    <title>Noticias</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <script src="index.js"></script>
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
</head>

<body>
    <section class="container">
        <form action="rss.php" method="POST" class="text-center">
            Url de noticias:
            <input type="text" id="url" name="url" placeholder="Ingresa tu url aquí :D" /><br><br>
            Número de noticias que quieres ver:
            <input type="text" id="numN" name="numN" required /><br><br>
            <input type="submit" id="verNoticias" value="Ver Noticias">
        </form>
    </section>
    <?php include 'consultas.php'; ?>
    <div id="news_Space">
    </div>
</body>