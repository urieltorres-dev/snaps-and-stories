<?php

require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';

$username = filter_input(INPUT_GET, 'username'); // Se obtiene el username del usuario a buscar.

$sqlCmd = "SELECT * FROM usuarios WHERE username = ?"; // Sentencia SQL a ejecutar.
$sqlParams = [$username];  // Parámetros a enviar en la consulta.
$db = getDbConnection();   // Se obtiene el objeto PDO para el acceso a DB.
$stmt = $db->prepare($sqlCmd);  // Preparamos la sentencia SQL a ejecutar y obtenemos el Statement.
$stmt->execute($sqlParams);  //  Ejecutamos la consulta.
$infoUsuario = $stmt->fetch();  // Obtenemos el resultado de la consulta.

?>
