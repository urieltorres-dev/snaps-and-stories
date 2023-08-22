<?php

require_once 'helpers/config.php';
require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';
require_once APP_PATH . 'app/perfil-propio.php';

$userId = filter_input(INPUT_GET, 'id');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/forms-perfil-pass.css">
    <title>Snaps & Stories</title>
</head>
<body>
    <header>
        <div class="container">
            <h2 class="log"><a href="home.php">
                Snaps & Stories
            </a></h2>
            <a href="perfil.php?username=<?php echo $USUARIO_USERNAME ?>&id=<?php echo $userId ?>"><button role="button" class="btn btn-regresar">Regresar</button></a>
        </div>
    </header>
    <!----------------MAIN---------------->
    <main>
        <div class="container">
            <div class="left"> <!--Columna izquierda-->
            </div>
            <div class="middle"> <!--Columna central-->
                <div class="form-img">
                    <div class="foto-usuario">
                        <h3>Editar foto de perfil</h3>
                        <div class="profile-photo">
                        <?php if (!$USUARIO_FOTO_PERFIL) : ?> <!--Si no hay foto de perfil-->
                            <img src="img/profile.png" alt="Foto de perfil" title="Foto de perfil" onclick="toggleMenu()">
                        <?php else : ?> <!--Si hay foto de perfil-->
                            <img src="helpers/ver.php?s_id=<?php echo $USUARIO_FOTO_PERFIL ?>" alt="Foto de perfil" title="Foto de perfil" onclick="toggleMenu()">
                        <?php endif; ?>
                        </div>
                        <form action="app/foto-perfil.php" id="formulario-foto-perfil" method="post" enctype="multipart/form-data">
                            <label for="foto">Subir IMG</label>
                            <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png" required />
                            <input type="submit" value="Guardar" />
                        </form>
                    </div>
                </div>
                <div class="form-datos">
                    <h3>Editar datos personales</h3>
                    <form action="app/editar-perfil.php" id="formulario-editar-perfil" method="post">
						<div class="inputBox">
                        <label for="email">Correo eléctronico: </label>
							<input type="email" id="email" name="email" value="<?php echo $infoUsuario["email"]?>" required>
						</div>
						<div class="inputBox">
                        <label for="nombre">Nombre: </label>
							<input type="text" id="nombre" name="nombre" value="<?php echo $infoUsuario["nombre"]?>" required>
						</div>
						<div class="inputBox">
                        <label for="apelldios">Apellidos: </label>
							<input type="text" id="apellidos" name="apellidos" value="<?php echo $infoUsuario["apellidos"]?>">
						</div>
						<div class="inputBox">
                        <label for="genero">Género: </label>
							<select id="genero" name="genero">
								<option value="">Seleccione tu género</option>
								<option value="M" <?php if ($infoUsuario['genero'] === 'M') { echo 'selected'; } ?>>Masculino</option>
								<option value="F" <?php if ($infoUsuario['genero'] === 'F') { echo 'selected'; } ?>>Femenino</option>
								<option value="O" <?php if ($infoUsuario['genero'] === 'O') { echo 'selected'; } ?>>Otro</option>
							</select>
						</div>
						<div class="inputBox">
                            <div class="guardar">
                                <input type="submit" value="Guardar">
                            </div>
						</div>
					</form>
                </div>
            </div>
            <div class="right"> <!--Columna derecha-->
            </div>
        </div>
    </main>
    <script src="js/editar-perfil.js"></script>
    <script src="js/foto-perfil.js"></script>
</body>
</html>