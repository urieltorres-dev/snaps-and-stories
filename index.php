<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Snaps & Stories</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
	<section>
		<div class="color"></div>
		<div class="color"></div>
		<div class="color"></div>
		<div class="box">
			<div class="square" style="--i:0;"></div>
			<div class="square" style="--i:1;"></div>
			<div class="square" style="--i:2;"></div>
			<div class="square" style="--i:3;"></div>
			<div class="square" style="--i:4;"></div>
			<div class="container">
				<div class="from">
					<h2>Iniciar Sesión</h2>
					<form action="app/iniciar-sesion.php" id="formulario-inicio-sesion" method="post">
						<div class="inputBox">
							<input type="text" id="username" name="username" placeholder="Nombre de usuario" value="demo_user" required>
						</div>
						<div class="inputBox">
							<input type="password" id="password" name="password" placeholder="Contraseña" value="123456" required>
						</div>
						<div class="inputBox">
							<input type="submit" value="Aceptar">
						</div>
						<p class="forget"><a href="registro.php">¿No tienes una cuenta? Da click aquí</a></p>
					</form>
				</div>
			</div>
		</div>
	</section>
	<script src="js/iniciar-sesion.js"></script>
</body>
</html>
