<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/png" href="../images/favicon.png" />
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css"/>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src="../mini-browser/news.js"></script>
    <title>Mini Browser</title>
  </head>
  <body background="../images/newspaper.jpg">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <img src="../images/rsslogo.png" alt="rss_logo" height="50" width="50">
        <a class="navbar-brand" href="index.php">Buscador de Noticias</a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="navbar-collapse collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link"><button type="button" class="btn btn-warning">Agregar</button></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link"><button type="button" class="btn btn-warning" id="watchAll">Ver todas</button></a>
                </li>
            </ul>
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Type to Search" aria-label="Search">
                <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <div class="container my-5 bg-dark text-white d-none" id="newsContainer">
        <h2>Your News:</h2>
        <div class="container  pt-3">
            <?php include 'indexar.php'?>
        </div>
    </div>
  </body>
</html>
