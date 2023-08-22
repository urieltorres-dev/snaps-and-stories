<?php

require_once 'helpers/config.php';
require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';

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
                <div class="form-datos">
                    <h3>Editar contraseña</h3>
                    <form action="app/cambiar-contraseña.php" id="formulario-cambiar-contraseña" method="post">
                        <div class="inputBox">
                            <label for="contraseña-actual">Contraseña anterior:</label>
							<input type="password" id="contraseña-actual" name="contraseña-actual" required>
						</div>
                        <div class="inputBox">
                            <label for="contraseña-nueva">Contraseña nueva:</label>
							<input type="password" id="contraseña-nueva" name="contraseña-nueva" required>
						</div>
						<div class="inputBox">
                        <label for="repetir-contraseña-nueva">Confirmar contraseña:</label>
							<input type="password" id="repetir-contraseña-nueva" name="repetir-contraseña-nueva" required>
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
    <script src="js/cambiar-contraseña.js"></script>
</body>
</html>