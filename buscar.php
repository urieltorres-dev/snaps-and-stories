<?php

require_once 'helpers/config.php';
require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';
require_once APP_PATH . 'app/buscar-usuario.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/buscar.css" rel="stylesheet"/>
    <title>Snaps & Stories</title>
</head>
<body>
    <header>
        <div class="container">
            <h2 class="log"><a href="home.php">
                Snaps & Stories
            </a></h2>
        </div>
    </header>
    <nav>
        <div class="container">
            <div class="search-bar">
                <form action="buscar.php" method="post">
                    <button type="submit" class="btn-buscar"><i class="fa fa-search"></i></button>
                    <input type="text" placeholder="Buscar" id="buscar-usuario" name="buscar-usuario">
                </form>
            </div>
            <a href="home.php"><button role="button" class="btn btn-regresar">Regresar</button></a>
        </div>
    </nav>
    <!----------------MAIN---------------->
    <main>
        <div class="container">
            <div class="left"> <!--Columna izquierda-->
            </div>
            <div class="middle"> <!--Columna central-->
                <div class="usuarios">
                    <h3>Resultados</h3>
                    <!-- FEED 1-->
                    <?php foreach ($r as $usuario) : ?>
                    <div class="user">
                        <div class="head">
                            <div class="user-info">
                                <div class="profile-photo">
                                <?php if (!$usuario["foto_perfil"]) : ?> <!--Si no hay foto de perfil-->
                                    <img src="img/profile.png" alt="Foto de perfil" title="Foto de perfil">
                                <?php else : ?> <!--Si hay foto de perfil-->
                                    <img src="helpers/ver.php?s_id=<?php echo $usuario["foto_perfil"] ?>" alt="Foto de perfil" title="Foto de perfil">
                                <?php endif; ?>
                                </div>
                                <div class="info">
                                    <h3><?php echo $usuario["nombre"] . " " . $usuario["apellidos"] ?></h3>
                                    <span><?php echo $usuario["username"] ?></span>
                                </div>
                            </div>
                            <div class="action-buttons">
                                <button class="btn btn-seguir btn-ver-perfil" data-username="<?php echo $usuario["username"] ?>" data-usuario-id="<?php echo $usuario["id"] ?>">Ver Perfil</button>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="right"> <!--Columna derecha-->
            </div>
        </div>
    </main>
    <script src="js/ver-perfil.js"></script>
</body>
</html>
