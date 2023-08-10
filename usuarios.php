<?php

require_once 'helpers/config.php';
require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';
require_once APP_PATH . 'app/followers.php';
require_once APP_PATH . 'app/following.php';

$username = filter_input(INPUT_GET, 'username');
$userId = filter_input(INPUT_GET, 'id');
$tipo = filter_input(INPUT_GET, 'tipo');
$r = NULL;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/usuarios.css">
    <title>Snaps & Stories</title>
</head>
<body>
    <header>
        <div class="container">
            <h2 class="log"><a href="home.php">
                Snaps & Stories
            </a></h2>
            <button role="button" class="btn btn-regresar"><a href="perfil.php?username=<?php echo $username ?>&id=<?php echo $userId ?>">Regresar</a></button>
        </div>
    </header>
    <!----------------MAIN---------------->
    <main>
        <div class="container">
            <div class="left"> <!--Columna izquierda-->
            </div>
            <div class="middle"> <!--Columna central-->
                <div class="usuarios">
                    <?php if ($tipo === "seguidores") : ?>
                        <h3>Seguidores</h3>
                    <?php else : ?>
                        <h3>Siguiendo</h3>
                    <?php endif ?>
                    <!-- FEED 1-->
                    <?php if ($tipo === "seguidores") : ?>
                        <?php foreach ($followers as $r) :?>
                            <div class="user">
                                <div class="head">             
                                    <div class="user-info">
                                        <div class="profile-photo">
                                        <?php if ($r["foto_perfil"] == null) : ?> <!--Si no hay foto de perfil, mostramos la imagen por defecto-->
                                            <img src="img/profile.png"> <!--Imagen por defecto-->
                                        <?php else : ?> <!--Si hay foto de perfil, mostramos la foto-->
                                            <img src="helpers/ver.php?s_id=<?php echo $r["foto_perfil"] ?>" alt="Foto de perfil" title="Foto de perfil">
                                        <?php endif; ?>
                                        </div>
                                        <div class="info">
                                            <h3><?php echo $r["nombre"] . " " . $r["apellidos"] ?></h3>
                                            <span><?php echo $r["username"] ?></span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?php foreach ($followin as $r) :?>
                            <div class="user">
                                <div class="head"> 
                                    <div class="user-info">
                                        <div class="profile-photo">
                                        <?php if ($r["foto_perfil"] == null) : ?> <!--Si no hay foto de perfil, mostramos la imagen por defecto-->
                                            <img src="img/profile.png"> <!--Imagen por defecto-->
                                        <?php else : ?> <!--Si hay foto de perfil, mostramos la foto-->
                                            <img src="helpers/ver.php?s_id=<?php echo $r["foto_perfil"] ?>" alt="Foto de perfil" title="Foto de perfil">
                                        <?php endif; ?>
                                        </div>
                                        <div class="info">
                                            <h3><?php echo $r["nombre"] . " " . $r["apellidos"] ?></h3>
                                            <span><?php echo $r["username"] ?></span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
            <div class="right"> <!--Columna derecha-->
            </div>
        </div>
    </main>
</body>
</html>
