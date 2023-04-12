<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AASANA - Preguntas Interactivas</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="../jquery.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid justify-content-between">
            <div class="d-flex">
                <a class="navbar-brand me-2 mb-1 d-flex align-items-center" href="#">
                    <img src="../logoweb.png" height="40" alt="Aasana Logo" />
                </a>
            </div>
            <ul class="navbar-nav flex-row">
                <li class="nav-item me-3 me-lg-1">
                    <a class="nav-link d-sm-flex align-items-sm-center" href="#">
                        <img src="img/unknown.png" class="rounded-circle" height="22" />
                        <strong
                            class="d-none d-sm-block ms-1"><?php if(isset($session->user['nickname'])){echo $session->user['nickname'];}?></strong>
                    </a>
                </li>
                <li class="nav-item me-3 me-lg-1">
                    <a class="nav-link" href="#">
                        <span><i class="fa-regular fa-power-off fa-lg"></i></span>
                    </a>
                </li>
                <li class="nav-item dropdown me-3 me-lg-1">
                    <a class="nav-link dropdown-toggle hidden-arrow" href="logout.php" id="" role="button"
                        data-mdb-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-chevron-circle-right fa-lg"></i>Salir
                    </a>
                </li>
            </ul>
        </div>
    </nav>