<?php

/**
 * Regresa una instancia de PDO para poder trabajar con la base de datos.
 */
function getDbConnection() {

	// Opciones para la conexión a DB.
	$options = [
		PDO::ATTR_EMULATE_PREPARES   => false, //desactiva la emulación de sentencias preparadas
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //manejo de errores
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //modo de fetch por default
	];

	// Creamos una instancia de tipo PDO, que es la que regresamos.
	// Los parámetros de conexión a DB están definidos en el archivo config.php.
	return new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, $options);
}

?>
