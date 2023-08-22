<?php

require_once 'helpers/config.php';
require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';
require_once APP_PATH . 'app/home.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/home.css" rel="stylesheet"/>
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
            <div class="publicar">
                <a href="#modal1"><button role="button" class="btn btn-publicar">Publicar</button></a>
                <div id="modal1" class="modalmask">
                    <div class="modalbox movedown">
                        <a href="#close" title="Close" class="close">X</a>
                        <form action="subir-foto.php" id="formulario-subir-foto" method="post" enctype="multipart/form-data">
                            <h3>Publicar una imagen</h3>
                            <hr>
                            <div class="alinear">
                                <label for="foto">Subir imagen </label>
                            </div>
                            <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png,.gif" required />
                            <br>
                            <div class="alinear">
                                <label for="txt-descripcion">Agregar una descripción: </label>
                                <textarea name="descripcion" id="descripcion" cols="50" rows="5"></textarea>
                            </div>
                            <br>
                                <div class="alinear">
                                <input type="submit" value="Publicar" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="search-bar">
                <form action="buscar.php" id="formulario-buscar-usuario" method="post">
                    <button type="submit" class="btn-buscar"><i class="fa fa-search"></i></button>
                    <input type="text" placeholder="Buscar" id="buscar-usuario" name="buscar-usuario">
                </form>
            </div>
            <div class="profile-photo">
                <?php if (!$USUARIO_FOTO_PERFIL) : ?> <!--Si no hay foto de perfil-->
                    <img src="img/profile.png" alt="Foto de perfil" title="Foto de perfil" onclick="toggleMenu()">
                <?php else : ?> <!--Si hay foto de perfil-->
                    <img src="helpers/ver.php?s_id=<?php echo $USUARIO_FOTO_PERFIL ?>" alt="Foto de perfil" title="Foto de perfil" onclick="toggleMenu()">
                <?php endif; ?>
            </div>
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <div class="profile-photo">
                            <?php if (!$USUARIO_FOTO_PERFIL) : ?> <!--Si no hay foto de perfil-->
                                <img src="img/profile.png" alt="Foto de perfil" title="Foto de perfil">
                            <?php else : ?> <!--Si hay foto de perfil-->
                                <img src="helpers/ver.php?s_id=<?php echo $USUARIO_FOTO_PERFIL ?>" alt="Foto de perfil" title="Foto de perfil">
                            <?php endif; ?>
                        </div>
                        <p><?php echo isset($USUARIO_ID) ? $USUARIO_USERNAME : "USUARIO"?></p> <!--Si hay usuario logueado, muestra su nombre de usuario, sino muestra "USUARIO"-->
                    </div>
                    <hr>
                    <a href="perfil.php?username=<?php echo $USUARIO_USERNAME ?>&id=<?php echo $USUARIO_ID ?>" class="sub-menu-link"><img src="img/profile.png"><p>Perfil</p><span>></span></a>
                    <a href="helpers/logout.php" class="sub-menu-link"><img src="img/logout.png"><p>Cerrar sesion</p><span>></span></a>
                </div>
            </div>
        </div>
    </nav>
    <!----------------MAIN---------------->
    <main>
        <div class="container">
            <div class="left"> <!--Columna izquierda-->
            </div>
            <div class="middle"> <!--Columna central-->
                <!--FEEDS-->
                <div class="feeds">
                    <?php foreach ($fotos as $r) : ?>
                    <!-- FEED 1-->
                    <div class="feed">
                        <div class="head">
                            <div class="user">
                                <div class="profile-photo">
                                    <?php if (!$r["usuario_subio_foto_perfil"]) : ?> <!--Si no hay foto de perfil-->
                                        <img src="img/profile.png" alt="Foto de perfil" title="Foto de perfil">
                                    <?php else : ?> <!--Si hay foto de perfil-->
                                        <img src="helpers/ver.php?s_id=<?php echo $r["usuario_subio_foto_perfil"] ?>" alt="Foto de perfil" title="Foto de perfil">
                                    <?php endif; ?>
                                </div>
                                <div class="info">
                                    <h3><?php echo $r["usuario_subio_username"] ?></h3>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="descripcion">
                            <p class="desc"><?php echo $r["descripcion"] ?></p>
                        </div>
                        <div class="photo">
                            <img src="helpers/ver.php?s_id=<?php echo $r["secure_id"] ?>" alt="<?php echo $r["nombre_archivo"] ?>" title="<?php echo $r["nombre_archivo"] ?>">
                        </div>
                        <div class="action-buttons">
                            <button class="btn-like" data-foto-id="<?php echo $r["id"] ?>" data-usuario-like="<?php echo $USUARIO_ID ?>">
                                <span id="icon" class="icon">
                                    <i class="fa fa-heart-o"></i>
                                </span>
                            </button>
                            <label class="contador"><?php echo $r["likes"] ?></label>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="right"> <!--Columna derecha-->
            </div>
        </div>
    </main>
    <script src="js/home.js"></script>
    <script src="js/subir-foto.js"></script>
    <script src="js/dar-like.js"></script>
</body>
</html>
