<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snaps & Stories</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/form.css">
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
					<h1>Ingrese sus datos</h1>
					<form action="app/registrar-usuario.php" id="formulario-registro" method="post">
						<div class="inputBox">
							<input type="text" id="username" name="username" placeholder="Nombre de usuario" required>
						</div>
						<div class="inputBox">
							<input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
						</div>
						<div class="inputBox">
							<input type="text" id="apellidos" name="apellidos" placeholder="Apellidos">
						</div>
						<div class="inputBox">
							<select id="genero" name="genero">
								<option value="">Seleccione su género</option>
								<option value="M">Masculino</option>
								<option value="F">Femenino</option>
								<option value="O">Otro</option>
							</select>
						</div>
						<div class="inputBox">
							<input type="email" id="email" name="email" placeholder="Correo electrónico" required>
						</div>
						<div class="inputBox">
							<input type="password" id="password" name="password" placeholder="Contraseña" required>
						</div>
						<div class="inputBox">
							<input type="password" id="password-confirm" name="password-confirm" placeholder="Confirmar contraseña" required>
						</div>
						<div class="inputBox">
							<input type="submit" value="Registrar">
						</div>
						<p class="forget"><a href="index.php">¿Ya tienes una cuenta? Da click aquí</a></p>
					</form>
				</div>	
			</div>
		</div>
	</section>
    <script src="js/registrar-usuario.js"></script>
</body>
</html>
