<?php

require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';

$username = filter_input(INPUT_GET, 'username');
$userId = filter_input(INPUT_GET, 'id');

$sqlCmd = "SELECT u.* FROM usuarios u JOIN seguidores s ON u.id = s.usuario_siguiendo_id WHERE s.usuario_seguidor_id = ? AND s.eliminado = ?"; // Sentencia SQL a ejecutar.
$sqlParams = [$userId, 0];  // Parámetros a enviar en la consulta.
$db = getDbConnection();   // Se obtiene el objeto PDO para el acceso a DB.
$stmt = $db->prepare($sqlCmd);  // Preparamos la sentencia SQL a ejecutar y obtenemos el Statement.
$stmt->execute($sqlParams);  //  Ejecutamos la consulta.
$followin = $stmt->fetchAll();  // Obtenemos el resultado de la consulta.
$numeroFollowin = count($followin); // Obtenemos el número de usuarios que estamos siguiendo.

?>
