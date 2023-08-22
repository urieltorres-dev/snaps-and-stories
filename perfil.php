<?php

require_once 'helpers/config.php';
require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';
require_once APP_PATH . 'app/perfil-propio.php';
require_once APP_PATH . 'app/fotos-propias.php';
require_once APP_PATH . 'app/following.php';
require_once APP_PATH . 'app/followers.php';

$username = filter_input(INPUT_GET, 'username');
$userId = filter_input(INPUT_GET, 'id');

if ($username != $USUARIO_USERNAME) {
    require_once APP_PATH . 'app/siguiendo.php';
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/perfil.css">
    <title>Snaps & Stories</title>
</head>
<body>
    <header>
        <div class="container">
            <h2 class="log"><a href="home.php" id="usuario-visitante" data-usuario-id="<?php echo $USUARIO_ID ?>">
                Snaps & Stories
            </a></h2>
        </div>
    </header>
    <nav>
        <div class="container">
            <div class="search-bar">
                <form action="buscar.php" method="post">
                    <button class="btn-buscar"><i class="fa fa-search"></i></button>
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
                <div class="perfil">
                    <div class="head">
                        <div class="profile-photo">
                            <?php if ($infoUsuario["foto_perfil"] == null) : ?> <!--Si no hay foto de perfil, mostramos la imagen por defecto-->
                                <img src="img/profile.png"> <!--Imagen por defecto-->
                            <?php else : ?> <!--Si hay foto de perfil, mostramos la foto-->
                                <img src="helpers/ver.php?s_id=<?php echo $infoUsuario["foto_perfil"] ?>" alt="Foto de perfil" title="Foto de perfil">
                            <?php endif; ?>
                        </div>
                        <?php if($username == $USUARIO_USERNAME) : ?>
                            <div>
                                    <a href="form-perfil.php?username=<?php echo $username ?>&id=<?php echo $userId ?>"><button class="btn editar">Editar perfil</button></a>
                            </div>
                            <div>
                                    <a href="form-pass.php?username=<?php echo $username ?>&id=<?php echo $userId ?>"><button class="btn pass">Editar contraseña</button></a>
                            </div>
                        <?php else : ?>
                            <div >
                                    <button class="btn seguir" id="btn-seguir"><?php echo $btnSeguir ?></button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="datos-usuario">
                        <ul class="datos">
                            <li>Nombre completo: <?php echo $infoUsuario["nombre"] . " " . $infoUsuario["apellidos"] ?></li>
                            <li id="usuario-visitado" data-usuario-id="<?php echo $infoUsuario["id"] ?>">Username: <?php echo $infoUsuario["username"]?></li>
                            <li>Genero: <?php if ($infoUsuario['genero'] === 'M') { echo 'Masculino';} else { echo 'Femenino'; } ?></li>
                        </ul>
                    </div>
                    <div class="usuarios">
                        <div class="siguiendo">
                            <p><?php echo $numeroFollowin?></p>
                            <p><a href="<?php echo "usuarios.php?username=" . $infoUsuario["username"] . "&id=" . $infoUsuario["id"]?>&tipo=siguiendo">Siguiendo</a></p>
                        </div>
                        <div class="seguidores">
                            <p><?php echo $numeroFollowers?></p>
                            <p><a href="<?php echo "usuarios.php?username=" . $infoUsuario["username"] . "&id=" . $infoUsuario["id"] ?>&tipo=seguidores">Seguidores</a></p>
                        </div>
                    </div>
                    <hr>
                    <div class="galeria">
                        <?php foreach ($fotos as $r): ?> <!--Recorremos las fotos del usuario-->
                        <div class="imagen" id="btn-foto-<?=$r["secure_id"]?>">
                            <div class="photo">
                            <img src="helpers/ver.php?s_id=<?php echo $r["secure_id"] ?>" alt="<?php echo $r["descripcion"] ?>" title="<?php echo $r["descripcion"] ?>" style="width: 100%;">
                            </div>
                            <?php if($username == $USUARIO_USERNAME) : ?>
                                <button class="btn delete btn-borrar" data-foto-secure-id="<?=$r["secure_id"]?>" data-foto-usuario-subio-id="<?=$r["usuario_subio_id"]?>">Eliminar</button>
                            <?php endif; ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <div class="right"> <!--Columna derecha-->
            </div>
        </div>
    </main>
    <script src="js/borrar-foto.js"></script>
    <?php if ($username != $USUARIO_USERNAME)  echo "<script src=js/seguir.js></script>" ?>
</body>
</html>
